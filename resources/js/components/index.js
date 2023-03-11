import BaseCard from "./BaseCard.vue";
import BaseList from "./BaseList.vue";
import BaseDescList from "./BaseDescList.vue";
import OrderDescItem from "./OrderDescItem.vue";
import BaseButton from "./BaseButton.vue";
import BaseListItem from "./BaseListItem.vue";
import BaseInput from "./BaseInput.vue";
import BaseSelect from "./BaseSelect.vue";

export default app => {
    app.component('BaseCard', BaseCard);
    app.component('BaseList', BaseList);
    app.component('BaseDescList', BaseDescList);
    app.component('OrderDescItem', OrderDescItem);
    app.component('BaseButton', BaseButton);
    app.component('BaseListItem', BaseListItem)
    app.component('BaseInput', BaseInput)
    app.component('BaseSelect', BaseSelect)
}
