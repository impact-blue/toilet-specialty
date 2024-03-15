window.addEventListener('load', () => {
  let areaToc = document.getElementById('toc_container');
  let containerUl = document.createElement('ul');

  const areaHeadings = document.querySelectorAll('#toc_area h2');

  if (areaHeadings.length !== 0) {
    areaHeadings.forEach((e, i) => {
      e.id = `i-${i}`;
      let li = document.createElement('li');
      let a = document.createElement('a');

      if (e.dataset.text) {
        a.innerHTML = `${i + 1} ${e.dataset.text}`;
      } else {
        a.innerHTML = `${i + 1} ${e.textContent}`;
      }

      a.href = `#i-${i}`;
      li.appendChild(a)
      containerUl.appendChild(li);

      areaToc.appendChild(containerUl);
    });
  }
})

$(function() {
  $(".toc_title").append('<span class="toc_toggle">[非表示]</span>');
});

$(function() {
  // 目次のアコーディオン
    $(".toc_toggle").click(function(){
    $(this).parent().next().slideToggle(200);
    if ($(this).text() === '[非表示]') {
      $(this).text('[表示]');
    } else {
      $(this).text('[非表示]');
    }
  });
});
