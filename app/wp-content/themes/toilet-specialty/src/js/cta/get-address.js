import { failureElements } from './elements';
import { getCtaData } from './main';

const axios = require('axios');

// 経度と緯度を元に位置情報の取得を行う
export const getAddressByLatAndLon = async (lat, lon) => {
  try {
    const origin = location.origin;
    const wpApiBaseUrl = `${origin}/wp-json/wp/custom/v1`;

    const res = await axios.post(`${wpApiBaseUrl}/exec_geocoding_api/`, {
      latitude: lat,
      longitude: lon
    });
    const data = await JSON.parse(res.data);

    // resultsの中でtypesの一番最初の要素にlocalityが入ってる配列を探す
    const results = data.results.find(e => e.types[0] === 'locality');

    // APIのリクエストには成功したが、権限周りの問題が発生した時
    if (data.status === 'REQUEST_DENIED') {
      console.error('リクエストが拒否されました');

      failureElements.forEach(e => e.style.display = 'block');

      return;
    }

    if (results) {
      // 都道府県・市区町村名のみを含む新しい配列を生成する
      const addressComponents = results.address_components.filter(e => {
        return e.types[0] === 'administrative_area_level_1' || e.types[0] === 'locality';
      });

      const prefName = addressComponents[1].long_name;
      const cityName = addressComponents[0].long_name;
      const areaName = `${prefName}${cityName}`;

      getCtaData(wpApiBaseUrl, areaName);
    }
  } catch (er) {
    console.error('APIのリクエストエラーが発生しました。');
    failureElements.forEach(e => e.style.display = 'block');
  }
};
