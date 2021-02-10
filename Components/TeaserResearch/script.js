import $ from 'jquery'
import Swiper from 'swiper/bundle'
import 'swiper/swiper-bundle.css'

class teaserResearch extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.props = this.getInitialProps()
    this.resolveElements()
    this.onResize()
  }

  getInitialProps () {
    let data = {}
    try {
      data = JSON.parse($('script[type="application/json"]', this).text())
    } catch (e) {}
    return data
  }

  resolveElements () {
    this.$slider = $('[data-slider]', this)
    this.$buttonNext = $('[data-slider-button="next"]', this)
    this.$buttonPrev = $('[data-slider-button="prev"]', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const { options } = this.props
    var config = {
      navigation: {
        nextEl: this.$buttonNext.get(0),
        prevEl: this.$buttonPrev.get(0)
      },
      slidesPerView: 1,
      spaceBetween: 10,
      slidesPerColumn: 1,
      breakpoints: {
        570: {
          slidesPerView: 2.3,
          slidesPerColumn: 1,
          spaceBetween: 30
        },
        900: {
          slidesPerView: 3.3,
          slidesPerColumn: 1,
          spaceBetween: 30
        },
        1180: {
          slidesPerView: 4.3,
          spaceBetween: 40,
          slidesPerColumn: 1
        }
      }
    }

    this.slider = new Swiper(this.$slider.get(0), config)
    var mySwiper = this.slider
    var next = $('.slider-button--next')
    var prev = $('.slider-button--prev')
    var mobilePrev = $('.slider-button-mobile--prev')
    var mobileNext = $('.slider-button-mobile--next')
    var wrapper = this.$slider.find($('.swiper-wrapper'))

    mobilePrev.on('click', function () {
      mySwiper.slidePrev()
      wrapper.removeClass('scroll')
    })

    mobileNext.on('click', function () {
      mySwiper.slideNext()
    })

    mySwiper.on('reachEnd', function () {
      mobileNext.on('click.back', function () {
        mySwiper.slideTo(0)
        wrapper.removeClass('scroll')
        $(this).off('click.back')
      })
    })

    prev.on('click', function () {
      wrapper.removeClass('scroll')
    })

    mySwiper.on('reachEnd', function () {
      this.on('transitionEnd', function () {
        next.removeClass('swiper-button-disabled')
      })
      wrapper.addClass('scroll')
      next.on('click', function () {
        mySwiper.slideTo(0)
        wrapper.removeClass('scroll')
        $(this).off('click')
      })
    })
  }

  onResize () {
    window.addEventListener('resize', this.resolveElements)
    window.addEventListener('resize', this.connectedCallback.bind(this))
  }
}

window.customElements.define('teaser-research', teaserResearch, { extends: 'section' })
