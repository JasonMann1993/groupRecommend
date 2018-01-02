<template>
    <div>
        <el-form ref="form" :rules="rules" :model="post" label-width="120px" v-loading="pageLoading">
            <el-form-item label="群聊名称" prop="name">
                <el-input v-model="post.name"></el-input>
            </el-form-item>
            <el-form-item label="群聊描述" prop="desc">
                <el-input v-model="post.desc"></el-input>
            </el-form-item>
            <el-form-item label="群聊地址" prop="address">
                <el-input v-model="post.address" disabled=""></el-input>
                <el-button @click="address.longitude = post.longitude, address.latitude = post.latitude,address.address= post.address, chooseAddress = true, chooseAddressType = 'edit'">选择</el-button>
            </el-form-item>
            <el-form-item label="成员分布">
                <el-row :gutter="10" style="margin: 0">
                    <el-col :span="8">
                        <el-input v-model="post.district_a" disabled></el-input>
                        <el-button @click="address.longitude = post.longitude_a, address.latitude = post.latitude_a,address.address= post.district_a,chooseAddress = true, chooseAddressType = 'a'">选择</el-button>
                    </el-col>
                    <el-col :span="8">
                        <el-input v-model="post.district_b" disabled></el-input>
                        <el-button @click="address.longitude = post.longitude_b, address.latitude = post.latitude_b,address.address= post.district_b,chooseAddress = true, chooseAddressType = 'b'">选择</el-button>
                    </el-col>
                    <el-col :span="8">
                        <el-input v-model="post.district_c" disabled></el-input>
                        <el-button @click="address.longitude = post.longitude_c, address.latitude = post.latitude_c,address.address= post.district_c,chooseAddress = true, chooseAddressType = 'c'">选择</el-button>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="群主微信昵称" prop="master">
                <el-input v-model="post.master"></el-input>
            </el-form-item>
            <el-form-item label="群主微信号" prop="wx">
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
                <upload @success="uploadSuccess" @remove="uploadRemove" :files="post.logo_url"></upload>
            </el-form-item>
            <el-form-item label="二维码" prop="picture">
                <upload @success="uploadSuccessQrCode" @remove="uploadRemoveQrCode" :files="post.qr_code_url"></upload>
            </el-form-item>
            <el-form-item label="排序" prop="order">
                <el-input type="number" v-model="post.order"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="center">
            <el-button type="primary" @click="onSubmit" :loading="buttonLoading">确定</el-button>
        </div>

        <el-dialog :visible.sync="chooseAddress" append-to-body>
            <chooseAddress @close="chooseAddress = false" @choose="handleChoose" :latitude="address.latitude" :longitude="address.longitude" :text="address.address"></chooseAddress>
        </el-dialog>
    </div>
</template>
<script>
    import CHOOSEADDRESS from './chooseAddress'

    export default {
        components: {
            'chooseAddress': CHOOSEADDRESS,
        },
        props: {
            id: Number
        },
        data() {
            return {
                chooseAddress: false,
                chooseAddressType: 'a',
                typeText: {
                    1: '用户',
                    2: '商家',
                },
                post: {},
                rules: {
                    name: [
                        {required: true, message: '请输入名称', trigger: 'blur'},
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
            },
            getInfo() {
                this.pageLoading = true
                this.$request.get(this.$url.home.group + '/' + this.id).then(res => {
                    this.pageLoading = false
                    this.post = res.data.data
                    this.shopLists = this.post.businesses
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
            },
            handleChoose(data) {
                if (this.chooseAddressType == 'edit') {
                    this.post.longitude = data.longitude
                    this.post.latitude = data.latitude
                    this.post.address = data.address
                    return;
                }
                let varNames = {
                    district: 'district_' + this.chooseAddressType,
                    latitude: 'latitude_' + this.chooseAddressType,
                    longitude: 'longitude_' + this.chooseAddressType,
                }

                this.post[varNames.district] = data.address
                this.post[varNames.latitude] = data.latitude
                this.post[varNames.longitude] = data.longitude
            }
        }
    }
</script>