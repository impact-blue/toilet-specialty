$(function() {
  // ボタンの連打防止用フラグ
  let btnControlFlg = false;

  // 郵便番号検索のメイン処理
  $('.zip-code-search-cmn .search-btn').on('click', function(e) {
    if (btnControlFlg) return;

    btnControlFlg = true;
    const plainInputZipCode = $(this).parent().children('.zip-code').val();
    const zipCode = trimZipCode(plainInputZipCode);

    try {
      validateZipCode(zipCode);

      // APIを使って地域名の非同期取得
      $.ajax({
        url: `https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zipCode}`,
        dataType: 'jsonp',
      }).done(function(data) {
        if (data.results) {
          const handleAreaFlg = isHandleArea(data.results[0].address1);
          setSearchResultData(data.results[0], handleAreaFlg);
          showSearchResultPopup(false);
        } else {
          // 存在しない郵便番号だった
          showErrorPopup(plainInputZipCode);
        }
      }).fail(function(data) {
        // API通信に失敗した
        showErrorPopup(plainInputZipCode);
      }).always(function() {
        btnControlFlg = false;
      });
    } catch(err) {
      // 入力値に誤りがあった or その他のエラーがあった
      showErrorPopup(plainInputZipCode);
      btnControlFlg = false;
    }
    return;
  });

  // 郵便番号の入力値チェック
  function validateZipCode(zipCode) {
    const length = zipCode.length;
    if (!$.isNumeric(zipCode) || length != 7) {
      throw new Error();
    }
    return true;
  }

  // 対応可能地域か
  function isHandleArea(prefName) {
    const prefNameList = $('.zip-code-search-cmn .pref-list li');
    let handleAreaFlg = false;
    prefNameList.each(function(index, element) {
      // 対応可能な都道府県名を取得
      const comparePrefName = $.trim($(element).text());
      if (prefName == comparePrefName) {
        handleAreaFlg = true;
        return false;
      }
    });
    return handleAreaFlg;
  }

  // 検索結果をhtmlにset
  function setSearchResultData(searchResult, handleAreaFlg){
    const frame = $('.zip-code-search-cmn .result');
    searchResult.zipcode = getWithHyphenZipCode(searchResult.zipcode);
    frame.find('.zip-code').text(searchResult.zipcode);

    frame.find('.result-zip-code').text(`〒${searchResult.zipcode}`);
    let address = '';
    if (searchResult.address1) {
      address = searchResult.address1;
    }
    if (searchResult.address2) {
      address = `${address}　${searchResult.address2}`;
    }
    if (searchResult.address3) {
      address = `${address}　${searchResult.address3}`;
    }
    frame.find('.result-area').text(address);

    const resultHandle = frame.find('.result-handle');
    if (handleAreaFlg) {
      resultHandle.text('対応可能');
      resultHandle.removeClass('out-range');
    } else {
      resultHandle.text('対応エリア範囲外になります');
      resultHandle.addClass('out-range');
    }
    return;
  }

  // 入力された郵便番号を半角・ハイフンなしに整形
  function trimZipCode(zipCode){
    // 全角数値を半角に置換
    zipCode = zipCode.replace(/[０-９]/g, function(s) {
      return String.fromCharCode(s.charCodeAt(0) - 65248);
    });
    // 000-0000と入力された場合のハイフンを除外
    zipCode = zipCode.replace(/[ー-]/g, "");
    return zipCode;
  }

  // ハイフンありの郵便番号
  function getWithHyphenZipCode(zipCode) {
    return `${zipCode.slice(0,3)}-${zipCode.slice(3)}`;
  }

  // エラー時のポップアップを表示
  function showErrorPopup(inputZipCode) {
    const frame = $('.zip-code-search-cmn .result');
    frame.find('.zip-code').text(inputZipCode);
    showSearchResultPopup(true);
  }

  // 検索結果のポップアップを表示
  function showSearchResultPopup(errorFlg) {
    const frame = $('.zip-code-search-cmn .result');
    if (errorFlg) {
      frame.find('.address').css('display', 'none');
      frame.find('.error').css('display', 'block');
      frame.find('.lower-box').css('display', 'none');
    } else {
      frame.find('.address').css('display', 'block');
      frame.find('.error').css('display', 'none');
      frame.find('.lower-box').css('display', 'block');
    }
    frame.css('display', 'block');
  }

  // ポップアップの閉じるボタン押下
  $('.zip-code-search-cmn .close-btn').on('click', function(e) {
    $('.zip-code-search-cmn .result').css('display', 'none');
  });
});

