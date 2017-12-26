<template>
    <div>
        <el-form ref="form" :rules="rules" :model="post" label-width="120px" v-loading="pageLoading">
            <el-form-item label="群聊名称" prop="name">
                <el-input v-model="post.name"></el-input>
            </el-form-item>
            <el-form-item label="群聊描述" prop="name">
                <el-input v-model="post.desc"></el-input>
            </el-form-item>
            <el-form-item label="群聊地址" prop="address" v-if="post.address && mapKey && mapUrl">
                <el-input v-model="post.address" disabled=""></el-input>
                <iframe allow="geolocation" width="100%" height="600" frameborder="0" :src="mapUrl">
                </iframe>
            </el-form-item>
            <el-form-item label="群主微信昵称" prop="name">
                <el-input v-model="post.master"></el-input>
            </el-form-item>
            <el-form-item label="群主微信号" prop="name">
                <el-input v-model="post.wx"></el-input>
            </el-form-item>
            <el-form-item label="入驻商家" prop="phone">
                <el-select v-model="post.business_ids" multiple filterable remote reserve-keyword placeholder="请输入关键词"
                           :remote-method="searchShop"
                           :loading="searchShopLoading">
                    <el-option v-for="shop in shopLists" :key="shop.id" :label="shop.name" :value="shop.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="LOGO" prop="logo">
                <upload @success="uploadSuccess" @remove="uploadRemove" :files="post.logo"></upload>
            </el-form-item>
            <el-form-item label="二维码" prop="picture">
                <upload @success="uploadSuccessQrCode" @remove="uploadRemoveQrCode" :files="post.qr_code"></upload>
            </el-form-item>
            <el-form-item label="排序" prop="order">
                <el-input type="number" v-model="post.order"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="center">
            <el-button type="primary" @click="onSubmit" :loading="buttonLoading">确定</el-button>
        </div>
    </div>
</template>
<script>

    export default {
        props: {
            id: Number
        },
        data() {
            return {
                typeText: {
                    1: '用户',
                    2: '商家',
                },
                post: {},
                rules: {
                    name: [
                        {required: true, message: '请输入用户名', trigger: 'blur'},
                        {min: 2, max: 15, message: '长度在 2 到 15 个字符', trigger: 'blur'}
                    ],
                },
                buttonLoading: false,
                pageLoading: false,
                searchShopLoading: false,
                shopLists: [],
                mapKey: null,
                address: {}
            }
        },
        computed: {
            mapUrl() {
                let url = "https://apis.map.qq.com/tools/locpicker?search=1&type=1&key=" + this.mapKey + "&referer=myapp"
                if (this.address.longitude && this.address.latitude)
                    url += '&coord=' + this.address.longitude + ',' + this.address.latitude
                return url
            }
        },
        watch: {
            id() {
                this.doLoad()
            }
        },
        mounted() {
            this.doLoad()
        },
        methods: {
            async doLoad() {
                await this.doResetForm()
                this.getInfo()
                this.getMap()
            },
            getInfo() {
                this.pageLoading = true
                this.$request.get(this.$url.home.group + '/' + this.id).then(res => {
                    this.pageLoading = false
                    this.post = res.data.data
                    this.shopLists = this.post.businesses
                    this.address = {
                        latitude: res.data.data.latitude,
                        longitude: res.data.data.longitude
                    }
                }).catch(error => {
                    this.pageLoading = false
                });
            },
            onSubmit() {
                this.doValidate(() => {
                    this.buttonLoading = true
                    this.$request.put(this.$url.home.group + '/' + this.id, this.post).then(res => {
                        this.buttonLoading = false
                        this.$notify({title: '编辑成功', type: 'success'});

                        this.$emit('success')
                        this.$emit('close')
                    }).catch(error => {
                        this.buttonLoading = false
                    });
                })
            },
            getMapKey() {
                this.$request.get(this.$url.home.map_key).then(res => {
                    this.mapKey = res.data.data
                })
            },
            getMap() {
                this.getMapKey()
                window.removeEventListener('message', event => {
                }, false)
                window.addEventListener('message', event => {
                    var loc = event.data;
                    if (loc && loc.module == 'locationPicker') {
                        this.post.longitude = loc.latlng.lng
                        this.post.latitude = loc.latlng.lat
                        this.post.address = loc.poiaddress
                    }
                }, false);
            },
            searchShop(query) {
                this.searchShopLoading = true;
                this.$request.get(this.$url.home.shop_search, {params: {keyword: query}}).then(res => {
                    this.searchShopLoading = false
                    this.shopLists = res.data.data
                }).catch(error => {
                    this.searchShopLoading = false
                });
            },
            doValidate(callback) {
                this.$refs['form'].validate((valid) => {
                    if (valid)
                        return callback()
                    return false;
                });
            },
            async doResetForm() {
                await this.$refs['form'].resetFields();
            },
            uploadSuccess(res) {
                this.post.logo = res.file
            },
            uploadRemove(res) {
                this.post.logo = null
            },
            uploadSuccessQrCode(res) {
                this.post.qr_code = res.file
            },
            uploadRemoveQrCode(res) {
                this.post.qr_code = null
            }
        }
    }
</script>