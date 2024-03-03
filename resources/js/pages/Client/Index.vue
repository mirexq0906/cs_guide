<template>
    <div class="flex gap-3 align-items-start h-full">
        <my-menu  class="w-20rem h-full" :items="items"/>
        <div class="flex-grow-1 h-full w-4rem">
            Главная
        </div>
    </div>
</template>
<script>
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import MyMenu from "@/components/common/MyMenu.vue";

export default {
    components: {
        MyMenu,
    },
    mixins: [fetchDataMixins],
    data() {
        return {
            items: [],
            requestRoute: '/categories'
        };
    },
    methods: {
        async handleGetRecords() {
            const response = await this.fetchGetData(this.requestRoute)
            if (response) {
                this.items = response.payload.map(category => {
                    return {
                        label: category.name,
                        items: category.sub_category.map(subCategory => {
                            return {
                                label: subCategory.name,
                                route: `/category/${category.id}/subcategory/${subCategory.id}`
                            };
                        })
                    };
                });
            }
        }
    },
    mounted() {
        this.handleGetRecords()
    }
};
</script>
