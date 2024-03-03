<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Редактирование записи" :is-loader="loader"
           :is-error="isError" :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-text v-model="data.name" field-title="Название категории"/>
                <field-dropdown v-model="data.category_id" field-title="Название категории" field-label="name"
                                field-value="id" :field-data="categories" field-placeholder="Выберите категорию"/>
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
                category_id: '',
            },
            categories: [],
            categoryRoute: '/categories'
        };
    },
    computed: {
        requestRoute() {
            return '/sub_categories/' + this.id;
        },
    },
    watch: {
        visible() {
            if (this.id && this.visible) {
                this.handleGetRecord()
                this.handleGetCategories()
            } else {
                this.clearError()
            }
        }
    },
    methods: {
        async handleUpdateRecord() {
            const formData = new FormData()
            formData.append('name', this.data.name);
            formData.append('img', this.data.img);

            const response = await this.fetchPostUpdateData(this.requestRoute, formData)
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
        async handleGetCategories() {
            const response = await this.fetchGetData(this.categoryRoute)
            if (response) {
                this.categories = response.payload
            }
        }
    }

}
</script>
