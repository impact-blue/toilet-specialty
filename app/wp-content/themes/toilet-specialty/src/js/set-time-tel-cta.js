$(function() {
  const date = new Date();
  const ctaList = $('.cta-time');

  ctaList.each(function(index, ctaItem){
    let ctaHour = $(ctaItem).find('.tel-cta-hour');
    let ctaMin = $(ctaItem).find('.tel-cta-min');

    $(ctaHour).text(date.getHours());
    $(ctaMin).text(date.getMinutes());
  });
});