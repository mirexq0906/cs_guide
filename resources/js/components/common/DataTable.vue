<template>
    <div class="data-table flex flex-column flex-grow-1 h-4rem">
        <DataTable class="h-full flex flex-column justify-content-between" @page="onPage($event)"
                   @sort="onSort($event)"
                   @filter="onFilter($event)"
                   @row-select="onRowSelect"
                   v-model:selection="selectedRow" v-model:filters="filters" removableSort sortMode="single"
                   :rows="rows"
                   :rowsPerPageOptions="rowsPerPageOptions" scrollable
                   selectionMode="single" :totalRecords="dataTotalRecords" :loading="dataTableLoading"
                   :metaKeySelection="metaKey" dataKey="id" :value="dataTable" lazy paginator
                   :filterDisplay="!isFilterDisplay ? null : 'row'" ref="dt">
            <template #empty>
                <div v-if="isError" class="text-red-600 text-center">{{ errorMessage }}</div>
                <div v-else class="text-center">Нет данных</div>
            </template>
            <template #loading>
                <loader-table/>
            </template>
            <Column v-for="item in tableConfig" :key="item.field" :field="item.field" :header="item.header"
                    :sortable="item.sort ? item.sort : false"
                    :style="{minWidth: item.minWidth !== undefined ? item.minWidth + 'px' : '200px'}">
                <template v-if="item.filter ? item.filter : false" #filter="{filterModel,filterCallback}">
                    <InputText v-if="item.type === 'simple_text'" type="text" v-model="filterModel.value"
                               @keydown.enter="filterCallback()"
                               class="p-column-filter" :placeholder="item.header"/>
                    <field-dropdown v-else-if="item.type === 'dropdown'" v-model="filterModel.value"
                                    @update-dropdown="filterCallback()" class="p-column-filter"
                                    :field-placeholder="item.header" :field-label="item.fieldLabel"
                                    :field-value="item.fieldValue" :field-data="item.fieldData"/>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import LoaderTable from "@/components/common/LoaderTable.vue";
import FieldDropdown from "@/components/common/FieldDropdown.vue";

export default {
    components: {
        FieldDropdown,
        LoaderTable,
        DataTable, Column, InputText
    },
    props: {
        dataTableLoading: {
            type: Boolean,
            required: true,
        },
        dataTable: {
            type: Array,
            default: () => []
        },
        tableConfig: {
            type: Array,
            default: () => []
        },
        updateTableKey: {
            type: Number,
            default: 0
        },
        dataTableFilters: {
            type: Object,
            required: true,
        },
        dataTotalRecords: {
            type: Number,
            required: true,
        },
        rows: {
            type: Number,
            default: 30
        },
        rowsPerPageOptions: {
            type: Array,
            default: () => [10, 30, 50, 100]
        },
        isError: {
            type: Boolean,
            default: false
        },
        errorMessage: {
            type: String,
            default: ''
        },
    },
    emits: ['rowClick', 'getData'],
    data() {
        return {
            filters: JSON.parse(JSON.stringify(this.dataTableFilters)),
            lazyParams: {},
            selectedRow: null,
            metaKey: true
        }
    },
    watch: {
        updateTableKey(newValue) {
            if (newValue > 0) {
                this.$emit('getData');
            }
        }
    },
    computed: {
        isFilterDisplay() {
            return this.tableConfig.some(item => item?.filter)
        }
    },
    methods: {
        onRowSelect(event) {
            this.$emit('rowClick', event.data)
        },
        onPage(event) {
            this.lazyParams = event;
            this.$emit('getData', this.lazyParams)
        },
        onSort(event) {
            this.lazyParams = event;
            this.$emit('getData', this.lazyParams)
        },
        onFilter(event) {
            this.lazyParams = event;
            this.$emit('getData', this.lazyParams)
        },
    },
    mounted() {
        this.lazyParams = {
            first: 0,
            rows: this.$refs.dt.rows,
            sortField: null,
            sortOrder: null,
            filters: this.filters
        };
        this.$emit('getData', this.lazyParams);
    }
}
</script>
<style>
.data-table .p-column-filter-menu-button {
    display: none;
}
</style>
