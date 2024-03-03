<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Просмотр записи" :is-loader="loader" :is-error="isError"
           :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-text v-model="data.name" field-title="Название места"/>
                <field-dropdown v-model="data.category_id" field-title="Название категории" field-label="name"
                                field-value="id" :field-data="categories" field-placeholder="Выберите категорию"/>
                <field-dropdown v-model="data.sub_category_id" field-title="Название подкатегории" field-label="name"
                                field-value="id" :field-data="sub_categories"
                                field-placeholder="Выберите подкатегорию"/>
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
                sub_category_id: '',
                category_id: ''
            },
            sub_categories: [],
            categories: [],
            requestRoute: '/places',
            requestSubCategories: '/sub_categories',
            requestCategories: '/categories'
        };
    },
    watch: {
        visible() {
            if (this.visible) {
                this.handleGetCategoriesRecord()
            } else {
                this.clearError()
            }
        },
        'data.category_id'(newValue) {
            this.handleGetRecord(newValue)
        }
    },
    methods: {
        async handleCreateRecord() {
            const response = await this.fetchPostCreateData(this.requestRoute, this.data)
            if (response) {
                this.$emit("dataChange");
                this.visible = false
            }
        },
        async handleGetRecord(id) {
            let filter = {
                field: 'category_id',
                operator: "equal",
                value: String(id)
            }
            const response = await this.fetchGetData(this.requestSubCategories, {filters: [filter]})
            if (response) {
                this.sub_categories = response.payload
            }
        },
        async handleGetCategoriesRecord() {
            const response = await this.fetchGetData(this.requestCategories)
            if (response) {
                this.categories = response.payload
            }
        }
    }

}
</script>
