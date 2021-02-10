<?php

namespace Flynt\Components\TeaserResearch;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\PostQuery;
use Timber\Timber;
use Timber\Post;

Options::addGlobal('TeaserResearch', [
  FieldVariables\getTitle(),
  FieldVariables\getDescription(),
  FieldVariables\getLink()
]);

function research_source_data_sort($array) {
  usort($array, function($a, $b) {
    if ($a['date'] == $b['date']) {
        return 0;
    }
    return ($a['date'] < $b['date']) ? 1 : -1;
  });
  return $array;
}

function research_source_data_merge($array) {
    $result = [];
    foreach ($array as $item) {
      $result[] = $item['id'];
    }
    return $result;
  }

add_filter('Flynt/addComponentData?name=TeaserResearch', function ($data) {

  $post = new Post();
  $context = Timber::get_context();
  $context['post'] = $post;

  if ($post->post_type == "issue") {
    $data['taxonomies'] = $post->terms('issue_type');
  } else if ($post->post_type == "workstream") {
    $data['taxonomies'] = $post->terms('workstream_type');
  }

  if ($post->post_type == "issue" OR $post->post_type == "workstream") {
    $research_taxonomy_params = array(
      'post_status' => 'publish',
      'post_type' => 'research',
      'tax_query' => array(
        array(
            'taxonomy' => $post->post_type.'_type',
            'field'    => 'slug',
            'terms'    => $data['taxonomies']
        )
      ),
      'orderby' => 'date',
      'order' => 'DESC',
      'posts_per_page' => 12,
    );

    $research_taxonomy = array();
    $research_taxonomy_date = [];
    $research_taxonomy_posts = Timber::get_posts($research_taxonomy_params);
    foreach($research_taxonomy_posts as $research_item) {
      $taxonomy_post = Timber::get_post($research_item->id);
      if (isset($taxonomy_post->custom['hero_source_date'])) {
        $research_taxonomy_date[] = ['id' => strval($taxonomy_post->id), 'date' => $taxonomy_post->custom['hero_source_date']];
      }
    }
    $research_taxonomy = research_source_data_merge(research_source_data_sort($research_taxonomy_date));
    $data['research_taxonomy'] = $research_taxonomy;
  }


    if ($post->post_type == "person") {
    $research_taxonomy_params = array(
      'post_status' => 'publish',
      'post_type' => 'research',
      'orderby' => 'date',
      'order' => 'DESC',
      'posts_per_page' => -1,
    );

    $research_authors = array();
    $research_taxonomy_posts = Timber::get_posts($research_taxonomy_params);

    foreach($research_taxonomy_posts as $research_item) {
      $taxonomy_post = Timber::get_post($research_item->id);
      $authors_main = $taxonomy_post->authors['person'];
      if (is_array($authors_main) && in_array($post->ID, $authors_main)) {
        array_push($research_authors, $taxonomy_post);
      }
    }
    $research_taxonomy_date = [];
    foreach($research_authors as $research_item) {
      $taxonomy_post = Timber::get_post($research_item->id);
      if (isset($taxonomy_post->custom['hero_source_date'])) {
        $research_taxonomy_date[] = ['id' => strval($taxonomy_post->id), 'date' => $taxonomy_post->custom['hero_source_date']];
      }
    }

    $research_taxonomy = research_source_data_merge(research_source_data_sort($research_taxonomy_date));
    $data['research_taxonomy'] = $research_taxonomy;
  }

  $research_recent_params = array(
    'post_status' => 'publish',
    'post_type' => 'research',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => '12',
  );

  $research_recent = array();
  $research_recent_date = [];
  $research_recent_posts = Timber::get_posts($research_recent_params);
  foreach($research_recent_posts as $research_item) {
    $recent_post = Timber::get_post($research_item->id);
    if (isset($recent_post->custom['hero_source_date'])) {
      $research_recent_date[] = ['id' => strval($recent_post->id), 'date' => $recent_post->custom['hero_source_date']];
    }
  }
  $research_recent = research_source_data_merge(research_source_data_sort($research_recent_date));

  $research_related = array();
  $research_related_date = [];
  if ($post->related_posts) {
    foreach($post->related_posts as $post_id) {
      $related_post = Timber::get_post($post_id);
      if ($related_post->post_type == "research" && isset($related_post->custom['hero_source_date'])) {
        $research_related_date[] = ['id' => strval($related_post->id), 'date' => $related_post->custom['hero_source_date']];
      }
    }
    $research_related = research_source_data_merge(research_source_data_sort($research_related_date));
  }

  $research_taxonomy = isset($data['research_taxonomy']) ? $data['research_taxonomy'] : [];


  if ($post->post_type == "issue" OR $post->post_type == "workstream" OR $post->post_type == "person" ) {
    $research_result = array_slice(array_unique(array_merge($research_related, $research_taxonomy, $research_recent)), 0, 12);
  } else {
    $research_result = array_slice(array_unique(array_merge($research_related, $research_recent)), 0, 12);
  }

  $data['research_related'] = $research_related;
  $data['research_recent'] = $research_recent;
  $data['research_result'] = $research_result;

  return $data;
});
