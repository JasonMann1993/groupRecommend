<template>
    <el-upload drag :file-list="filesLists" :action="$url.home.upload" :on-success="success" :on-remove="remove" :limit="1" list-type="picture">
        <i class="el-icon-upload"></i>
        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
    </el-upload>
</template>
<script>
    export default {
        props: {
            files: [Array, String],
            url: [String]
        },
        data() {
            return {}
        },
        computed: {
            filesLists() {
                if(this.files){
                    return [{
                        name: this.files,
                        url: this.files
                    }]
                }
                return []
            }
        },
        mounted() {
        },
        methods: {
            success(response, file, fileList) {
                this.$emit('success', response, file, fileList)
            },
            remove(file, fileList) {
                this.$emit('remove', file, fileList)
            }
        }
    }
</script>
