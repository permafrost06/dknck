import { find, addClasses, rmClasses } from '../../utils';

const infoEL = find('#product-info');

find('#product-id').addEventListener('keydown', function(evt) {
    if (evt.key === 'Enter') {
        evt.preventDefault();
        fetchInfo(this.value);
        return;
    }
});

let productFetchSignal = null;

async function fetchInfo(id) {
    id = id.trim();
    if (!id) {
        infoEL.innerHTML = '';
        return;
    }
    id = parseInt(id.replace(/([^0-9]+)/, ''));
    rmClasses(infoEL, 'text-skin-success text-skin-danger');
    infoEL.innerHTML = 'Loading...';
    if (productFetchSignal) {
        productFetchSignal.abort();
        productFetchSignal = new AbortController();
    }
    const res = await (await fetch(PRODUCT_INFO_URL.replace('::ID::', id))).json();
    productFetchSignal = null;
    if (!res.product) {
        infoEL.innerHTML = "No product found!";
        addClasses(infoEL, 'text-skin-danger');
        rmClasses(infoEL, 'text-skin-success');
    } else {
        infoEL.innerHTML = `Name: ${res.product.name}, Price: ${res.product.unit_price_buying}TK`;
        rmClasses(infoEL, 'text-skin-danger');
        addClasses(infoEL, 'text-skin-success');
    }
}

fetchInfo(find('#product-id').value);