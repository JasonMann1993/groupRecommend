<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
        </page-info>
        <div class="qr-code" v-loading="loading">
            <img :src="url" alt="" width="300">
            <h2>
                <a :href="url" download="coupons.png"><el-button plain size="">保存二维码</el-button></a>
            </h2>
            <h3>【请打印并放置于醒目位置，便于用户领取优惠券】</h3>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                loading: false,
                url: '',
                title: '我的传播二维码'
            }
        },
        watch: {
            '$store.state.user.unique_id': function (newValue) {
                if (newValue)
                    this.doLoad()
            }
        },
        mounted() {
            if (this.$store.state.user.unique_id)
                this.doLoad()
        },
        methods: {
            doLoad() {
                this.loading = true
                this.$request.get(this.$url.api.qr_code, {
                    isApi: true,
                    params: {id: this.$store.state.user.unique_id}
                }).then(res => {
                    this.url = res.data.data.data
                    this.loading = false
                }).catch(res => {
                    this.loading = false
                })
            },
        }
    }
</script>

<style lang="scss" scoped>
    .qr-code {
        background: white;
        padding: 2rem;
        text-align: center;
        min-height: 300px;
    }
</style>