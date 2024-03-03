<template>
    <div class="flex flex-column h-full">
        <my-breadcrumb class="flex-shrink-0" :data-breadcrumb="dataBreadcrumb"/>
        <div class="flex-grow-1 h-1rem gallery-action">
            <Galleria :value="data" :showItemNavigators="true" :showThumbnails="false"
                      :numVisible="1">
                <template #item="slotProps">
                    <img class="gallery-action__img" :src="slotProps.item.src" :alt="slotProps.item.alt"
                         style="width: 100%; display: block"/>
                </template>
                <template #caption="slotProps">
                    <div class="text-xl mb-2 font-bold">{{ slotProps.item.alt }}</div>
                    <p class="text-white">{{ slotProps.item.desc }}</p>
                </template>
            </Galleria>
        </div>
    </div>
</template>
<script>
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Galleria from 'primevue/galleria';

export default {
    name: "Places",
    components: {
        Galleria
    },
    mixins: [fetchDataMixins],
    data() {
        return {
            data: [],
            dataBreadcrumb: [
                {
                    label: "Раскидки",
                    route: `/category/${this.$route.params.category_id}/subcategory/${this.$route.params.sub_category_id}`
                },
                {label: "Действие"},
            ]
        }
    },
    computed: {
        requestRoute() {
            return '/actions/' + this.$route.params.action_id
        }
    },
    watch: {
        requestRoute() {
            this.handleGetRecord()
        }
    },
    methods: {
        async handleGetRecord() {
            const response = await this.fetchGetData(this.requestRoute)
            if (response) {
                this.data = [
                    {
                        src: response.payload.img_start,
                        alt: "Куда встать",
                        desc: response.payload.desc
                    },
                    {
                        src: response.payload.img_end,
                        alt: "Куда смотреть",
                        desc: response.payload.desc
                    },
                    {
                        src: response.payload.img_middle,
                        alt: "Куда прилетит",
                        desc: response.payload.desc
                    },
                ]
            }
        }
    },
    mounted() {
        this.handleGetRecord()
    }
}
</script>
<style>
.p-galleria .p-galleria-item-nav {
    color: black;
}

.gallery-action {
    .p-galleria, .p-galleria-content, .p-galleria-item-wrapper {
        height: 100%;
    }
    .gallery-action__img {
        height:100%;
        object-fit: cover;
    }
}
</style>


