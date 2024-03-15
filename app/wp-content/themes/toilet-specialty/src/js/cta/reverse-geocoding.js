import { failureElements } from './elements';
import { getAddressByLatAndLon } from './get-address';

export const reverseGeocoding = () => {
  if (navigator.geolocation) {
    // アロー関数だと引数リストの参照ができないので普通のfunction()を使用
    navigator.geolocation.getCurrentPosition(successFunc , errorFunc);

    function successFunc(position) {
      const lat = position.coords.latitude;
      const lon = position.coords.longitude

      getAddressByLatAndLon(lat, lon);
    }

    function errorFunc(er) {
      failureElements.forEach(e => e.style.display = 'block');
    }
  } else {
    // Geolocation APIを利用できない環境向けの処理
    console.log('位置情報の取得に失敗');
    failureElements.forEach(e => e.style.display = 'block');
  }
};
