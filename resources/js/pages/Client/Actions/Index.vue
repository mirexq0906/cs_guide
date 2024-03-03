<template>
    <div class="flex gap-3 align-items-start h-full  ">
        <my-menu class="w-20rem h-full overflow-auto" @set-filter="handleGetRecords" @set-item="setAction" :data-filter="dataFilter"
                 filter-label="name" filter-value="id" :is-hover="true" :items="items"/>

        <div class="flex-grow-1 h-full h-full overflow-auto">
            <div v-if="this.$route.name === 'places'" class="h-full h-full">
                <my-breadcrumb :data-breadcrumb="dataBreadcrumb"/>
                <div class="relative" style="width:800px">
                    <div v-if="activeAction" class="w-2rem h-2rem bg-primary absolute border-circle"
                         :style="{top: activeAction?.coordinates_start?.y + 'px', left: activeAction?.coordinates_start?.x + 'px'}"/>
                    <div v-if="activeAction" class="w-2rem h-2rem bg-orange-500 absolute border-circle"
                         :style="{top: activeAction?.coordinates_end?.y + 'px', left: activeAction?.coordinates_end?.x + 'px'}"/>
                    <Image :src="categoryData.img" alt="Image" />
                </div>
            </div>
            <router-view v-else name="placesPage"/>
        </div>
    </div>
</template>
<script>
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Image from 'primevue/image';
import MyMenu from "@/components/common/MyMenu.vue";

export default {
    name: "Index.vue",
    components: {
        Image, MyMenu
    },
    mixins: [fetchDataMixins],
    data() {
        return {
            items: [],
            dataFilter: [],
            categoryData: {},
            activeAction: null,
            dataBreadcrumb: [
                {label: "Раскидки"},
            ]
        }
    },
    computed: {
        requestRoute() {
            return '/actions'
        },
        requestCategory() {
            return '/categories/' + this.$route.params.category_id
        }
    },
    methods: {
        setAction(item) {
            this.activeAction = item
        },
        async handleGetRecords(filterId) {
            let params = {
                page: 1,
                limit: 9999999,
                filters: [
                    {
                        field: 'category_id',
                        operator: "equal",
                        value: this.$route.params.category_id
                    },
                    {
                        field: 'sub_category_id',
                        operator: "equal",
                        value: this.$route.params.sub_category_id
                    },
                ]
            }
            if(filterId) {
                params.filters.push({
                    field: 'place_end_id',
                    operator: "equal",
                    value: filterId
                })
            }
            const response = await this.fetchGetData(this.requestRoute, params)
            if (response) {
                this.items = response.payload.map(action => {
                    return {
                        label: action?.place_start.name + '_' + action?.place_end.name,
                        route: `/category/${action.category_id}/subcategory/${action.sub_category_id}/action/${action.id}`,
                        place_end: action?.place_end,
                        coordinates_start: JSON.parse(action.coordinates_start),
                        coordinates_end: JSON.parse(action.coordinates_end),
                    };
                });
                if(!filterId) {
                    this.dataFilter = [...new Set(
                        this.items.map(item => {
                            return JSON.stringify({id: item.place_end.id, name: item.place_end.name});
                        })
                    )].map(str => JSON.parse(str));
                }
            }
        },
        async handleGetCategory() {
            const response = await this.fetchGetData(this.requestCategory)
            if (response) {
                this.categoryData = response.payload
            }
        }
    },
    mounted() {
        this.handleGetRecords()
        this.handleGetCategory()
    }
}
</script>
<style>

</style>
