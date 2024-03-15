import {
  areaNames,
  areaPageItemName,
  areaPageItemSlug,
  areaPageLinkBtns,
  failureElements,
  itemNames,
  successElements,
} from './elements';
import { storage } from './storage';

const axios = require('axios');

// 現在地に紐づくエリア名をDBから取得する
export const getCtaData = async (wpApiBaseUrl, areaName) => {
  try {
    let customApiRes;

    if (areaPageItemName !== null && areaPageItemSlug !== null) {
      const itemName = areaPageItemName.textContent;
      customApiRes = await axios.get(`${wpApiBaseUrl}/find_area_and_detail/${areaName}/${itemName}/`);
    } else {
      customApiRes = await axios.get(`${wpApiBaseUrl}/find_area/${areaName}/`);
    }

    const customApiData = await customApiRes.data;

    // 取得結果と取得した配列を定数に代入
    const customApiStatus = customApiData.status;
    const customApiResults = customApiData.data;

    customApiStatus ? successCase(customApiResults) : failureCase();
  } catch (er) {
    console.error(er);
  }
}

// エリア名の取得に成功した時の処理
export const successCase = customApiResults => {
  areaNames.forEach(e => e.textContent= customApiResults.area_name);

  // セッションストレージに保存
  storage.setItem('areaName', areaNames[0].textContent);

  // アイテム名はエリア詳細ページの時のみ取得できる
  if (customApiResults.item_name) {
    itemPageCase(customApiResults);
  }

  successElements.forEach(e => e.style.display = 'block');
};

// アイテム詳細ページだった時の処理
const itemPageCase = customApiResults => {
  itemNames.forEach(e => e.textContent = customApiResults.item_name);

  // 関連記事が取得できない場合は、処理を終わらせる
  if (customApiResults.area_page_slug === '') return;

  // エリア詳細ページのリンクの設定
  const link = areaPageLinkBtns[0].href;
  areaPageLinkBtns.forEach(e => e.href = `${link}/${customApiResults.area_page_slug}`);

  // セッションストレージに保存
  storage.setItem('itemName', itemNames[0].textContent);
  storage.setItem('areaPageUrl', areaPageLinkBtns[0].href);

  // ボタンの表示を切り替え
  areaPageLinkBtns.forEach(e => e.style.display = 'inline-block');
};

// 対応エリア外・位置情報が取得できない場合の処理
export const failureCase = () => {
  failureElements.forEach(e => e.style.display = 'block');
};
