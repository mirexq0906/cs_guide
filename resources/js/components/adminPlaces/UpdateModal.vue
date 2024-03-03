<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Редактирование записи" :is-loader="loader"
           :is-error="isError" :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-text v-model="data.name" field-title="Название места"/>
                <field-dropdown v-model="data.category_id" field-title="Название категории" field-label="name"
                                field-value="id" :field-data="categories" field-placeholder="Выберите категорию"/>
                <field-dropdown v-model="data.sub_category_id" field-title="Название подкатегории" field-label="name"
                                field-value="id" :field-data="sub_categories" field-placeholder="Выберите подкатегорию"/>
            </div>
        </template>
        <template v-slot:footer>
            <Button @click="handleUpdateRecord" label="Редактировать запись" severity="warning"/>
        </template>
    </Modal>
</template>
<script>
import FieldText from "@/components/common/FieldText.vue";
import FieldImage from "@/components/common/FieldImage.vue";
import Button from 'primevue/button';
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Modal from "@/components/common/Modal.vue";
import FieldDropdown from "@/components/common/FieldDropdown.vue";

export default {
    name: "UpdateModal",
    components: {
        Modal,
        FieldText,
        Button,
        FieldImage,
        FieldDropdown,
    },
    mixins: [fetchDataMixins],
    emits: ['dataChange'],
    data() {
        return {
            id: null,
            visible: false,
            data: {
                name: "",
                sub_category_id: '',
                category_id: '',
            },
            sub_categories: [],
            categories: [],
            subCategoryRoute: '/sub_categories',
            categoryRoute: '/categories'
        };
    },
    computed: {
        requestRoute() {
            return '/places/' + this.id;
        },
    },
    watch: {
        visible() {
            if (this.id && this.visible) {
                this.handleGetRecord()
                this.handleGetCategories()
                this.handleGetSubCategories()
            } else {
                this.clearError()
            }
        }
    },
    methods: {
        async handleUpdateRecord() {
            const response = await this.fetchPostUpdateData(this.requestRoute, this.data)
            if (response) {
                this.$emit("dataChange");
                this.visible = false
            }
        },
        async handleGetRecord() {
            const response = await this.fetchGetData(this.requestRoute);
            if (response) {
                this.data = response.payload;
            }
        },
        async handleGetSubCategories() {
            const response = await this.fetchGetData(this.subCategoryRoute)
            if (response) {
                this.sub_categories = response.payload
            }
        },
        async handleGetCategories() {
            const response = await this.fetchGetData(this.categoryRoute)
            if (response) {
                this.categories = response.payload
            }
        }
    }

}
</script>
