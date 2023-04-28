import omit from "lodash/omit";

export function queryParams() {
    return Object.fromEntries(new URLSearchParams(window.location.search).entries());
}
export function queryParamsExcept(keys) {
    let params = queryParams();

    return omit(params, keys);
}
