//全角英数記号を半角に変換する
const replaceToHalfWidth = strVal => {
  var halfVal = String(strVal).replace(/[！-～]/g, function (str) {
    return String.fromCharCode(str.charCodeAt(0) - 0xFEE0);
  });

  // 文字コードシフトで対応できない文字の変換
  return halfVal.replace(/”/g, "\"")
    .replace(/’/g, "'")
    .replace(/‘/g, "`")
    .replace(/￥/g, "\\")
    .replace(/　/g, " ")
    .replace(/〜/g, "~")
}
export { replaceToHalfWidth }