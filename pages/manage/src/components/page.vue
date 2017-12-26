<template>
    <el-pagination
            layout="total, prev, pager, next"
            :total="data.total"
            :current-page="data.current_page"
            :page-size="data.per_page"
            @current-change="changePage" v-if="data.total">
    </el-pagination>
</template>
<script>
    export default {
        props: ['data'],
        methods: {
            changePage(now) {
                let query = this.$util.copyObj(this.$route.query)
                query.page = now
                this.$router.push({query})
            }
        }
    }
</script>
