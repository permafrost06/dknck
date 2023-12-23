import { find, addClasses, rmClasses } from '../../utils';

const infoEL = find('#item-info');

find('#item-id').addEventListener('keydown', function(evt) {
    if (evt.key === 'Enter') {
        evt.preventDefault();
        fetchInfo(this.value);
        return;
    }
});

let itemFetchSignal = null;

async function fetchInfo(id) {
    id = id.trim();
    if (!id) {
        infoEL.innerHTML = '';
        return;
    }
    id = parseInt(id.replace(/([^0-9]+)/, ''));
    rmClasses(infoEL, 'text-skin-success text-skin-danger');
    infoEL.innerHTML = 'Loading...';
    if (itemFetchSignal) {
        itemFetchSignal.abort();
        itemFetchSignal = new AbortController();
    }
    const res = await (await fetch(ITEM_INFO_URL.replace('::ID::', id))).json();
    itemFetchSignal = null;
    if (!res.item) {
        infoEL.innerHTML = "No item found!";
        addClasses(infoEL, 'text-skin-danger');
        rmClasses(infoEL, 'text-skin-success');
    } else {
        infoEL.innerHTML = `Name: ${res.item.name}, Price: ${res.item.unit_price_buying}TK`;
        rmClasses(infoEL, 'text-skin-danger');
        addClasses(infoEL, 'text-skin-success');
    }
}

fetchInfo(find('#item-id').value);