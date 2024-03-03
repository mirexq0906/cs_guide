<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Просмотр записи" :is-loader="loader" :is-error="isError"
           :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-text v-model="data.name" field-title="Название категории"/>
                <field-image v-model="data.img"/>
            </div>
        </template>
        <template v-slot:footer>
            <Button @click="handleCreateRecord" label="Создать запись" severity="success"/>
        </template>
    </Modal>
</template>
<script>
import FieldText from "@/components/common/FieldText.vue";
import FieldImage from "@/components/common/FieldImage.vue";
import Button from 'primevue/button';
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Modal from "@/components/common/Modal.vue";

export default {
    name: "CreateModal",
    components: {
        Modal,
        FieldText,
        Button,
        FieldImage,
    },
    mixins: [fetchDataMixins],
    emits: ['dataChange'],
    data() {
        return {
            visible: false,
            data: {
                name: "",
                img: null,
            },
            requestRoute: '/categories'
        };
    },
    watch: {
        visible() {
            if (!this.visible) {
                this.clearError()
            }
        }
    },
    methods: {
        async handleCreateRecord() {
            const formData = new FormData()
            formData.append('name', this.data.name);
            formData.append('img', this.data.img);
            const response = await this.fetchPostCreateData(this.requestRoute, formData)
            if (response) {
                this.$emit("dataChange");
                this.visible = false
            }
        }
    }

}
</script>
