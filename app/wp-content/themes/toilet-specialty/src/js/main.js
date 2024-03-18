import $ from 'jquery';
import objectFitImages from 'object-fit-images';
import slick from 'slick-carousel';
import 'slick-carousel/slick/slick.css';

// jQueryをグローバルでも使用できるようにする
window.$ = $;
window.jQuery = $;

// object-fitのpolyfill
objectFitImages();

jQuery(function($) {
  // よくある質問のアコーディオン
  if (location.pathname === '/questions/') {
    $('.item .question').on('click', function() {
      $(this).next().slideToggle();
      $(this).toggleClass('active');
    });
  }

  // 市区町村ページの工務店情報のアコーディオン
  $('.shop-info-ttl').on('click', function() {
    $(this).next().slideToggle();
    $(this).toggleClass('active');
  })

  // 記事一覧のタグのアコーディオン
  $('#item-terms .tags-description-wrapper').on('click', function() {
    $(this).next().slideToggle();
    $(this).toggleClass('active');
  });

  // フッターのアコーディオン
  $('#footer .toggle-header').on('click', function() {
    // SPのみ反応
    if (window.outerWidth <= 768) {
      $(this).next().slideToggle();
      $(this).toggleClass('active');
    }
  });

  // ナビの開閉
  $('#sp-nav-btn').on('click', function() {
    $('#nav').toggleClass('nav-fixed');
    $('#nav > ul').toggleClass('nav-open');
    $('#header').toggleClass('header-fixed');
    $('#layer').toggleClass('active');

    // FVに都道府県名・市区町村名が存在した場合の処理
    if ($('.area-name-label').length) {
      $('.area-name-label').toggleClass('toggle-area-label');
    }

    if ($('#nav > ul').hasClass('nav-open')) {
      const headerHeight = $('#header').innerHeight();
      $('#nav').css({top: `${headerHeight}px`});
    }
    if (!$('#nav > ul').hasClass('nav-open')) {
      const headerHeight = $('#header').innerHeight();
      $('#nav').css({top: '0px'});
    }
  });

  // ナビの閉じるボタン
  $('#close-li').on('click', function() {
    $('#nav').removeClass('nav-fixed');
    $('#nav > ul').removeClass('nav-open');
    $('#header').removeClass('header-fixed');
    $('#layer').removeClass('active');

    if ($('.area-name-label').length) {
      $('.area-name-label').removeClass('toggle-area-label');
    }
  });

  // 施工事例コンテンツのスライダー
  function constructionExampleSlider() {
    const mainSliders = document.querySelectorAll('.main-slider');

    if (mainSliders.length === 0) return;

    for (let i = 1; i <= mainSliders.length; i++) {
      const mainSliderClassName = '.main-slider-' + i;
      const thumbnailsSliderClassName = '.thumbnails-slider-' + i;

      $(mainSliderClassName).slick({
        fade: true,
        infinite: true,
        prevArrow: '<span class="slider-arrow prev-arrow"></span>',
        nextArrow: '<span class="slider-arrow next-arrow "></span>',
        asNavFor: thumbnailsSliderClassName,
      });

      $(thumbnailsSliderClassName).slick({
        infinite: true,
        slidesToShow: 7,
        asNavFor: mainSliderClassName,
        focusOnSelect: true,
        arrows: false,
      });
    }
  }

  constructionExampleSlider();

  // トップへ戻るボタン
  $(window).on('scroll',function(){
    100 < $(this).scrollTop()
      ? $('#pagetop').fadeIn('fast')
      : $('#pagetop').fadeOut('fast');
  })

  $('#pagetop').on('click', function() {
    return $('body,html').animate({ scrollTop:0 },400), !1;
  })

  // お急ぎの方へのリンク変更
  window.onEmergencyLinkClick = function onEmergencyLinkClick(phoneNumber) {
    if (document.body.clientWidth <= 768) {
      location.href = `tel:${phoneNumber}`;
    } else {
      location.href = '/contact/';
    }
  }

  // お急ぎの方へのクラス変更
  if($(window).width() <= 768) {
    $('#hurryBtn').addClass('tel-menu');
  }

  // 対応エリアモーダル
  $('.area-modal-btn').on('click', function() {
    $(this).siblings('.area-modal-wrapper').addClass('active');
  })
  $('.area-modal-bg, .area-modal-close').on('click', function() {
    $(this).closest('.area-modal-wrapper').removeClass('active');
  })

  // SP時のみスライダー適用
  $(window).on('load resize', function() {
    if ($('.customer-voice-slider')) {
      const width = $(window).width();
      if(width <= 768){
        $('.customer-voice-slider').not('.slick-initialized').slick({
          arrows: true,
          prevArrow: '<div class="customer-voice-prev-arrow"></div>',
          nextArrow: '<div class="customer-voice-next-arrow"></div>'
        });
      } else {
        $('.customer-voice-slider.slick-initialized').slick('unslick');
      }
    }
  });

  // 料金比較表のアコーディオン
  $(".table-price-comparison").on('click', function(){
    $(this).next().slideToggle();
    $(this).find(".table-area-bar._low").toggleClass("_open");
  });

  // よくある質問のアコーディオン
  $(".question._top").on('click', function(){
    $(this).next().slideToggle();
    $(this).find(".question-bar._low").toggleClass("_open");
  });


  // エリアページの口コミの表示件数の変更
  const voice_init_num = 3
  const voice_more_num = 3

  $(".customer-voice-item:nth-of-type(n+" + (voice_init_num + 1) + ")._common").hide();

  $(".customer-voice-container").filter(function(){
    return $(this).find(".customer-voice-item").length <= voice_init_num
  }).find(".voice-more-btn").hide();

  $(".voice-more-btn").on('click',function(){
    let this_list = $(this).closest(".customer-voice-container");
    this_list.find(".customer-voice-item:hidden").slice(0, voice_more_num).slideToggle();

    if(this_list.find(".customer-voice-item:hidden").length == 0) {
      $(this).fadeOut();
    }
  });

  // 市区町村ページの工務店情報のアコーディオン
  $('.water-info-subttl').on('click', function() {
    $(this).next().slideToggle();
    $(this).children().toggleClass('_active');
  })

  // トップページの指定番号コンテンツのアコーディオン
  $('.top-admitted-head').on('click', function() {
    $(this).next().slideToggle();
    ;
  })

  // 大エリアの対応エリア一覧のアコーディオン
  $(".area-block-ttl.pref").on('click', function(){
    $(this).parent().next().slideToggle();
    $(this).next().slideToggle();
    $(this).find(".area-block-bar.low").toggleClass("open");
  });

  // 施工事例タグのアコーディオン
  $('.sekou-tags-btn').on('click', function() {
    $(this).next().slideToggle();
  })
});