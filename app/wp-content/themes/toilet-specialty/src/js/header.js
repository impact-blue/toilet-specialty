$(function() {
  // 施工事例一覧のアコーディオン
    $(".ac-head").click(function(){
    $(this).next().slideToggle();
    $(this).toggleClass("_open");
    $(this).find(".ac-icon").toggleClass("_rotate");
  });
});