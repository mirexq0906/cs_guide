<template>
    <div class="flex gap-3 align-items-start h-full">
        <TieredMenu class="w-20rem h-full" :model="items">
            <template #item="{ item, props, hasSubmenu }">
                <router-link v-if="item.route">
                    <a class="flex align-items-center" :href="item.href" v-bind="props.action">
                        <span :class="item.icon"/>
                        <span class="ml-2">{{ item.label }}</span>
                        <span v-if="item.shortcut"
                              class="ml-auto border-1 surface-border border-round surface-100 text-xs p-1">
                            {{ item.shortcut }}
                        </span>
                        <i v-if="hasSubmenu" class="pi pi-angle-right ml-auto"></i>
                    </a>
                </router-link>
                <a v-else class="flex align-items-center" :href="item.href" v-bind="props.action">
                    <span :class="item.icon"/>
                    <span class="ml-2">{{ item.label }}</span>
                    <span v-if="item.shortcut"
                          class="ml-auto border-1 surface-border border-round surface-100 text-xs p-1">
                            {{ item.shortcut }}
                        </span>
                    <i v-if="hasSubmenu" class="pi pi-angle-right ml-auto"></i>
                </a>
            </template>
        </TieredMenu>
        <div class="flex-grow-1 h-full w-4rem">
            <router-view name="adminPage"></router-view>
        </div>
    </div>
</template>
<script>
import TieredMenu from 'primevue/tieredmenu';

export default {
    components: {
        TieredMenu
    },
    data() {
        return {
            items: [
                {
                    label: 'Категории',
                    icon: 'pi pi-file-edit',
                    href: '/admin/categories',
                },
                {
                    label: 'Подкатегории',
                    icon: 'pi pi-file-edit',
                    href: '/admin/sub_categories',
                },
                {
                    label: 'Места',
                    icon: 'pi pi-file-edit',
                    href: '/admin/places'
                },
                {
                    label: 'Действия',
                    icon: 'pi pi-file-edit',
                    href: '/admin/actions',
                },
            ]
        };
    }
};
</script>
