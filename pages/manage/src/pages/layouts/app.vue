<template>
    <el-container id="content">
        <el-header>
            <main-header></main-header>
        </el-header>
        <el-container id="content-main">
            <el-aside>
                <main-sidebar></main-sidebar>
            </el-aside>
            <el-main id="content-body">
                <router-view></router-view>
            </el-main>
        </el-container>
        <el-footer>
            <main-footer></main-footer>
        </el-footer>
    </el-container>
</template>
<script>
    import MainHeader from "@/components/header.vue";
    import MainFooter from "@/components/footer.vue";
    import MainSidebar from "@/components/sidebar.vue";

    export default {
        components: {
            MainSidebar,
            MainFooter,
            MainHeader,
        },
//        mounted() {
//            setInterval(this.$util.refreshToken, 3000)
//        },
        data() {
            return {}
        },
    }
</script>
<style lang="scss">
    @import "../../assets/scss/base";
</style>
