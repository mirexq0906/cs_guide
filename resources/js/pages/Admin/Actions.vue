<template>
    <div class="flex flex-column h-full">
        <div class="flex align-items-center justify-content-between mb-3">
            <div class="text-2xl font-medium">
                Просмотр всех записей
            </div>
            <Button @click="openCreateModal" severity="success" label="Создать категорию"/>
        </div>
        <data-table @get-data="(data) => fetchGetTableData(tableDataRequest, data)" @row-click="openViewModal"
                    :data-table-loading="loader" :data-table-filters="filters" :updateTableKey="updateTableKey"
                    :table-config="tableConfig" :data-table="dataTable" :data-total-records="dataTotalRecords"
                    :is-error="isError" :error-message="errorMessage"/>
    </div>

    <view-modal @data-change="updateTableKey++" @open-edit-modal="openUpdateModal" ref="viewActionModal"/>
    <create-modal @data-change="updateTableKey++" ref="createActionModal"/>
    <update-modal @data-change="updateTableKey++" ref="updateActionModal"/>
</template>
<script>
import Button from 'primevue/button';
import DataTable from '@/components/common/DataTable.vue'
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import ViewModal from "@/components/adminActions/ViewModal.vue";
import CreateModal from "@/components/adminActions/CreateModal.vue";
import UpdateModal from "@/components/adminActions/UpdateModal.vue";

export default {
    components: {
        ViewModal,
        DataTable,
        Button,
        CreateModal,
        UpdateModal
    },
    mixins: [fetchDataMixins],
    data() {
        return {
            dataTable: [],
            tableConfig: [
                {
                    header: '#',
                    type: 'simple_text',
                    sort: true,
                    filter: true,
                    field: 'id',
                },
                {
                    header: 'Категория',
                    type: 'dropdown',
                    fieldData: [],
                    fieldValue: 'id',
                    fieldLabel: 'name',
                    sort: true,
                    filter: true,
                    field: 'category.name',
                },
                {
                    header: 'Подкатегория',
                    type: 'dropdown',
                    fieldData: [],
                    fieldValue: 'id',
                    fieldLabel: 'name',
                    sort: true,
                    filter: true,
                    field: 'sub_category.name',
                },
                {
                    header: 'Дата создания',
                    type: 'simple_text',
                    sort: true,
                    filter: true,
                    field: 'created_at',
                },
                {
                    header: 'Дата обновления',
                    type: 'simple_text',
                    sort: true,
                    filter: true,
                    field: 'updated_at',
                },
            ],
            filters: {
                id: {value: '', matchMode: 'contains'},
                'category.name': {value: '', matchMode: 'equals'},
                'sub_category.name': {value: '', matchMode: 'equals'},
                created_at: {value: '', matchMode: 'contains'},
                updated_at: {value: '', matchMode: 'contains'},
            },
            dataTotalRecords: 0,
            updateTableKey: 0,
            tableDataRequest: '/actions',
            requestSubCategories: '/sub_categories',
            requestCategories: '/categories',
        };
    },
    methods: {
        closeModals() {
            this.$refs.viewActionModal.visible = false;
            this.$refs.updateActionModal.visible = false;
            this.$refs.createActionModal.visible = false;
        },
        openViewModal(data) {
            this.closeModals();
            this.$refs.viewActionModal.id = data.id;
            this.$refs.viewActionModal.visible = true;
        },
        openUpdateModal(id) {
            console.log(id)
            this.closeModals();
            this.$refs.updateActionModal.id = id;
            this.$refs.updateActionModal.visible = true;
        },
        openCreateModal() {
            this.closeModals();
            this.$refs.createActionModal.visible = true;
        },
        async handleGetSubCategories() {
            const response = await this.fetchGetData(this.requestSubCategories)
            if (response) {
                const subCategoryFieldConfig = this.tableConfig.find(item => item.field === 'sub_category.name');
                subCategoryFieldConfig.fieldData = response.payload;
            }
        },
        async handleGetCategories() {
            const response = await this.fetchGetData(this.requestCategories)
            if (response) {
                const categoryFieldConfig = this.tableConfig.find(item => item.field === 'category.name');
                categoryFieldConfig.fieldData = response.payload;
            }
        }
    },
    mounted() {
        this.handleGetSubCategories();
        this.handleGetCategories();
    }
};
</script>
