<template>
    <Dialog @hide="clearModal" v-model:visible="visible" dismissable-mask :draggable="false" modal
            :header="modalTitle" class="w-full m-4 relative" :style="{ maxWidth: `${maxWidth}px` }">
        <slot name="content"/>
        <template #footer>
            <slot name="footer"/>
        </template>
        <div class="mt-2 text-red-600" v-if="isError">{{errorMessage}}</div>

        <Loader :is-loader="isLoader"/>
    </Dialog>
</template>
<script>
import Dialog from 'primevue/dialog';
import ClearModalMixins from "@/mixins/ClearModalMixins.js";
import Loader from "@/components/common/Loader.vue";
export default {
    name: "Modal",
    components: {
        Dialog,
        Loader,
    },
    emits: ['update:modelValue', 'update:data'],
    mixins: [ClearModalMixins],
    props: {
        modalTitle: {
            type: String,
            default: ''
        },
        maxWidth: {
            type: Number,
            default: 450
        },
        isLoader: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            type: Boolean,
            default: false,
        },
        data: {
            type: Object,
            default: {},
        },
        isError: {
            type: Boolean,
            default: false
        },
        errorMessage: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            visible: this.modelValue
        }
    },
    watch: {
        visible() {
            this.$emit('update:modelValue', this.visible)
        },
        modelValue(newValue) {
            this.visible = newValue
        }
    }
}
</script>


