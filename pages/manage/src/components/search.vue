<template>
    <el-card class="box-card">
        <div slot="header">
            <h3 v-text="title"></h3>
        </div>
        <div>
            <el-form :inline="true" :model="search">
                <slot></slot>
                <el-form-item>
                    <el-button type="primary" @click="doSearch" icon="el-icon-search">确定
                    </el-button>
                </el-form-item>
            </el-form>
        </div>
    </el-card>
</template>
<script>
    export default {
        props: {
            title: {
                type: String,
                default: '筛选'
            },
            search: Object,
            load: Function,
            push: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            doSearch() {
                this.search.page = "1"
                if ((this.load && this.$util.compareObj(this.$route.query, this.search)) || !this.push)
                    this.load()
                else
                    this.$router.push({query: this.search})
            }
        }
    }
</script>
