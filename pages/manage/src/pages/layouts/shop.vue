<template>
    <el-container id="content">
        <el-header>
            <shop-header></shop-header>
        </el-header>
        <el-container id="content-main">
            <el-aside>
                <shop-sidebar></shop-sidebar>
            </el-aside>
            <el-main id="content-body">
                <router-view></router-view>
            </el-main>
        </el-container>
        <el-footer>
            <shop-footer></shop-footer>
        </el-footer>
    </el-container>
</template>
<script>
    import ShopHeader from "@/components/shop/header.vue";
    import ShopFooter from "@/components/shop/footer.vue";
    import ShopSidebar from "@/components/shop/sidebar.vue";

    export default {
        components: {
            ShopSidebar,
            ShopFooter,
            ShopHeader,
        },
        data() {
            return {}
        }
    }
</script>
<style lang="scss">
    @import "../../assets/scss/base";
</style>
