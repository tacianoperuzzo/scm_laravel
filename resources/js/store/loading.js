import { reactive } from 'vue';

export const loading = reactive({
    show: false,
    show() {
        this.state = true;
    },
    hide() {
        this.state = false;
    },
    showing() {
        return this.state
    }
})
