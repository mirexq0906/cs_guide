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

    <view-modal @data-change="updateTableKey++" @open-edit-modal="openUpdateModal" ref="viewCategoryModal"/>
    <create-modal @data-change="updateTableKey++" ref="createCategoryModal"/>
    <update-modal @data-change="updateTableKey++" ref="updateCategoryModal"/>
</template>
<script>
import Button from 'primevue/button';
import DataTable from '@/components/common/DataTable.vue'
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import ViewModal from "@/components/adminCategories/ViewModal.vue";
import CreateModal from "@/components/adminCategories/CreateModal.vue";
import UpdateModal from "@/components/adminCategories/UpdateModal.vue";

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
                    header: 'Изображение карты',
                    type: 'simple_text',
                    sort: true,
                    filter: true,
                    field: 'img',
                },
                {
                    header: 'Название категории',
                    type: 'simple_text',
                    sort: true,
                    filter: true,
                    field: 'name',
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
                img: {value: '', matchMode: 'contains'},
                name: {value: '', matchMode: 'contains'},
                created_at: {value: '', matchMode: 'contains'},
                updated_at: {value: '', matchMode: 'contains'},
            },
            dataTotalRecords: 0,
            updateTableKey: 0,
            tableDataRequest: '/categories'
        };
    },
    methods: {
        closeModals() {
            this.$refs.viewCategoryModal.visible = false;
            this.$refs.updateCategoryModal.visible = false;
            this.$refs.createCategoryModal.visible = false;
        },
        openViewModal(data) {
            this.closeModals();
            this.$refs.viewCategoryModal.id = data.id;
            this.$refs.viewCategoryModal.visible = true;
        },
        openUpdateModal(id) {
            this.closeModals();
            this.$refs.updateCategoryModal.id = id;
            this.$refs.updateCategoryModal.visible = true;
        },
        openCreateModal() {
            this.closeModals();
            this.$refs.createCategoryModal.visible = true;
        }
    },
};
</script>
