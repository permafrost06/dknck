import { ref } from 'vue';

export function useSorter(initial, order = 'desc') {
    let sort_by = initial;
    let sort_type = order;
    const sorted = ref({
        by: sort_by,
        order: sort_type
    });
    return [
        sorted,
        (by) => {
            if(sort_by == by){
                sort_type = sort_type === 'desc' ? 'asc' : 'desc';
            }else{
                sort_by = by;
                sort_type = order;
            }
            sorted.value.by = by;
            sorted.value.order = sort_type;
            return sorted.value;
        }
    ]
}