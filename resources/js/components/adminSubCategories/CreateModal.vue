<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Просмотр записи" :is-loader="loader" :is-error="isError"
           :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-text v-model="data.name" field-title="Название подкатегории"/>
                <field-dropdown v-model="data.category_id" field-title="Название категории" field-label="name"
                                field-value="id" :field-data="categories" field-placeholder="Выберите категорию"/>
            </div>
        </template>
        <template v-slot:footer>
            <Button @click="handleCreateRecord" label="Создать запись" severity="success"/>
        </template>
    </Modal>
</template>
<script>
import FieldText from "@/components/common/FieldText.vue";
import Button from 'primevue/button';
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Modal from "@/components/common/Modal.vue";
import FieldDropdown from "@/components/common/FieldDropdown.vue";

export default {
    name: "CreateModal",
    components: {
        FieldDropdown,
        Modal,
        FieldText,
        Button,
    },
    mixins: [fetchDataMixins],
    emits: ['dataChange'],
    data() {
        return {
            visible: false,
            data: {
                name: "",
                category_id: '',
            },
            categories: [],
            requestRoute: '/categories',
            requestSubCategories: '/sub_categories',
        };
    },
    watch: {
        visible() {
            if (this.visible) {
                this.handleGetRecord()
            } else {
                this.clearError()
            }
        }
    },
    methods: {
        async handleCreateRecord() {
            const response = await this.fetchPostCreateData(this.requestSubCategories, this.data)
            if (response) {
                this.$emit("dataChange");
                this.visible = false
            }
        },
        async handleGetRecord() {
            const response = await this.fetchGetData(this.requestRoute)
            if (response) {
                this.categories = response.payload
            }
        }
    }

}
</script>
