<template>
    <TieredMenu @mouseout="setItem(null)" :model="items">
        <template #start>
            <div class="pl-1 pr-1">
                <Dropdown v-if="dataFilter.length" v-model="selected" :options="dataFilter" :option-label="filterLabel"
                          :option-value="filterValue.length ? filterValue : null" placeholder="Выберите место"
                          class="w-full"  showClear/>
            </div>
        </template>
        <template #item="{ item, props, hasSubmenu }">
            <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                <a @mouseover="setItem(item)" :href="href" v-bind="props.action" @click="navigate">
                    <span class="ml-2">{{ item.label }}</span>
                </a>
            </router-link>
            <a @mouseover="setItem(item)" v-else :href="item.url" :target="item.target" v-bind="props.action">
                <span class="ml-2">{{ item.label }}</span>
                <span v-if="hasSubmenu" class="pi pi-angle-right ml-auto"/>
            </a>
        </template>
    </TieredMenu>
</template>
<script>
import TieredMenu from "primevue/tieredmenu";
import Dropdown from 'primevue/dropdown';

export default {
    name: "MyMenu.vue",
    components: {
        TieredMenu, Dropdown
    },
    emits: ['setItem', 'setFilter'],
    props: {
        items: {
            type: Array,
            default: () => []
        },
        isHover: {
            type: Boolean,
            default: false
        },
        filterLabel: {
            type: String,
            default: ''
        },
        filterValue: {
            type: String,
            default: ''
        },
        dataFilter: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            selected: null,
        }
    },
    watch: {
        selected(newValue) {
            this.$emit('setFilter', newValue)
        }
    },
    methods: {
        setItem(item) {
            this.$emit('setItem', item)
        },
    }
}
</script>
