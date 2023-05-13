import omit from "lodash/omit";

export function queryParams(key) {
    console.log((new URLSearchParams(window.location.search)).values())
    let params = Object.fromEntries(new URLSearchParams(window.location.search).entries())

    return key ? params[key] : params;
}

export function queryParamsExcept(keys) {
    let params = queryParams();

    return omit(params, keys);
}

export const numberFormat = (number, decimals = 2, dec_point = '.', thousands_sep = ' ') => {
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        toFixedFix = function (n, prec) {
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            var k = Math.pow(10, prec);
            return Math.round(n * k) / k;
        },
        s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
