import {
  areaNames,
  areaPageLinkBtns,
  itemNames,
  successElements,
} from './elements';
import { reverseGeocoding } from './reverse-geocoding';
import { storage } from './storage';

window.addEventListener('DOMContentLoaded', () => {
  const pathname = location.pathname;
  const reg = /\/item_detail\/.+$/;

  // sessionStorageにStorageオブジェクトがある場合
  if (storage.length !== 0) {
    successElements.forEach(e => e.style.display = 'block');
    areaNames.forEach(e => e.textContent = storage.getItem('areaName'));

    // アイテム詳細ページで行う処理
    if (reg.test(pathname) && storage.getItem('itemName') && storage.getItem('areaPageUrl')) {
      areaPageLinkBtns.forEach(e => {
        e.style.display = 'inline-block';
        e.href = storage.getItem('areaPageUrl');
      });

      itemNames.forEach(e => e.textContent = storage.getItem('itemName'));
    }
  } else {
    // Storageオブジェクトがない場合は現在地から位置情報を取得する
    reverseGeocoding();
  }
});
