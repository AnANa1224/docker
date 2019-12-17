<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>导航菜单管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="add">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div @click="local('navigation')" class="el-page-header">
                            <div class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">新增</div>
                        </div>
                    </div>
                </div>
                <div class="forms">
                    <form class="el-form" style="width: 500px;">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">菜单类型</label>
                            <select v-model.number="add.type_id" name="edit_cate" style="width: 300px; height: 40px">
                                <option value="1">导航</option>
                                <option value="2">广告</option>
                                <option value="3">小图</option>
                                <option value="4">大图</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">标题</label>
                            <input v-model="add.title" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请输入标题">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">链接类型</label>
                            <select v-model.number="add.link_type" @change="changeLink" name="edit_cate" style="width: 300px; height: 40px">
                                <option value="-1">请选择</option>
                                <option value="1">商品分类页</option>
                                <option value="2">商品购买页</option>
                                <option value="3">商品活动页</option>
                                <option value="4">店铺页</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">链接目标</label>
                            <select v-model.number="add.link_target" name="edit_cate" style="width: 300px; height: 40px">
                                <option v-for="target in targets" :value="target.id">{{target.name}}</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">排序</label>
                            <select v-model.number="add.sort" name="sort" id="edit_sort" style="width: 300px; height: 40px">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">状态</label>
                            <select v-model.number="add.status" name="status" id="edit_status" style="width: 300px; height: 40px">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>

                        <div class="source">
                            <div>
                                <div>
                                    <ul class="el-upload-list el-upload-list--picture-card">
                                        <li v-if="imgUrl" tabindex="0" class="el-upload-list__item is-success">
                                            <img :src="imgUrl" alt="" class="el-upload-list__item-thumbnail">
                                            <label class="el-upload-list__item-status-label">
                                                <i class="el-icon-upload-success el-icon-check"></i>
                                            </label>
                                            <i class="el-icon-close"></i>
                                            <i class="el-icon-close-tip">按 delete 键可删除</i>
                                            <span class="el-upload-list__item-actions">
                                                    <span @click="bigImg(imgUrl)" class="el-upload-list__item-preview">
                                                        <i class="el-icon-zoom-in"></i>
                                                    </span>
                                                    <span @click="delImg()" class="el-upload-list__item-delete">
                                                        <i class="el-icon-delete"></i>
                                                    </span>
                                                </span>
                                        </li>
                                    </ul>
                                    <label for="file" tabindex="0" class="el-upload el-upload--picture-card">
                                        <i class="el-icon-plus"></i>
                                        <input @change="uploadImg($event)" type="file" name="file" id="file" class="el-upload__input" style="display: none">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="el-form-item">
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <button type="button" class="el-button el-button--primary" style="width: 300px;" @click="addNav"><span>保存</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--  大图  -->
        <div v-if="bigImgList" class="el-dialog__wrapper" style="z-index: 2052;">
            <div role="dialog" aria-modal="true" aria-label="dialog" class="el-dialog" style="margin-top: 15vh;">
                <div class="el-dialog__header">
                    <span class="el-dialog__title"></span>
                    <button @click="bigImgList=false" type="button" aria-label="Close" class="el-dialog__headerbtn">
                        <i class="el-dialog__close el-icon el-icon-close"></i>
                    </button>
                </div>
                <div v-if="bigImgList" class="el-dialog__body">
                    <img width="100%" :src="bigImgMsg" alt="">
                </div>
            </div>
        </div>
        <div v-if="bigImgList" class="v-modal" tabindex="0" style="z-index: 2051;"></div>

    </div>
    <!-- END MAIN -->
</template>

<script>
    export default {
        name: "CreateNav",
        data() {
            return {
                id:Number,
                apiUrl:'',
                targets:[{id:'-1',name:'请先选择链接类型'}],
                add:{type_id:1,title:'',picture:'',link_type:-1,link_target:-1,sort:10,status:1},
                imgUrl:'',
                bigImgList:false,
                bigImgMsg:{},
                notice:'',
            }
        },
        mounted() {
            this.apiUrl = global.origin;
        },
        methods: {
            addNav(){
                this.add.picture = this.imgUrl;
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/nav/create',
                    params:this.add,
                    responseType:'json'
                }).then( res => {
                    this.notice = this.add.title +' '+ res.data.msg;
                    if (res.data.code === 0) {
                        this.success(false);
                        this.add = {type_id:1,title:'',picture:'',link_type:-1,link_target:-1,sort:10,status:1};
                        this.imgUrl = '';
                    } else {
                        this.error(false);
                    }
                })
            },
            changeLink(){
                if (this.add.link_type === 1) {
                    axios({
                        method: 'get',
                        url: this.apiUrl+'/api/category',
                        responseType: 'json'
                    }).then( res => {
                        this.add.link_target = -1;
                        this.targets = [{id:'-1',name:'请选择'}];
                        this.targets = this.targets.concat(res.data.data);
                        // this.targets = res.data.data;
                    })
                } else if (this.add.link_type === 2) {
                    axios({
                        method: 'get',
                        url: this.apiUrl+'/api/product',
                        responseType: 'json'
                    }).then( res => {
                        this.add.link_target = -1;
                        this.targets = [{id:'-1',name:'请选择'}];
                        this.targets = this.targets.concat(res.data.data);
                    })
                } else if (this.add.link_type === 3) {
                    this.add.link_target = -1;
                    this.targets = [{id:'-1',name:'暂无活动'}];
                } else if (this.add.link_type === 4) {
                    this.add.link_target = -1;
                    this.targets = [{id:'-1',name:'暂无店铺'}];
                } else {
                    this.add.link_target = -1;
                    this.targets = [{id:'-1',name:'请先选择链接类型'}];
                }

            },
            targrtDetail(){
                if (this.edit.link_type === 1) {
                    axios({
                        method: 'get',
                        url: this.apiUrl+'/api/category',
                        responseType: 'json'
                    }).then( res => {
                        this.targets = res.data.data;
                        this.$Spin.hide();
                    })
                } else if (this.edit.link_type === 2) {
                    axios({
                        method: 'get',
                        url: this.apiUrl+'/api/product',
                        responseType: 'json'
                    }).then( res => {
                        this.targets = res.data.data;
                        this.$Spin.hide();
                    })
                } else if (this.edit.link_type === 3) {
                    this.targets = [{id:'-1',name:'暂无活动'}];
                    this.$Spin.hide();
                } else if (this.edit.link_type === 4) {
                    this.targets = [{id:'-1',name:'暂无店铺'}];
                    this.$Spin.hide();
                }
            },
            uploadImg(e){
                this.handleSpinCustom();
                if (this.imgUrl !== '') {
                    this.notice = '上传失败,只能添加一张图片';
                    this.warning(false);
                    this.$Spin.hide();
                    return false;
                }
                let file = e.target.files[0];
                // console.log(file);
                // 预览
                // let url = URL.createObjectURL(file);
                // this.avatar_url = url;
                let params = new FormData();
                params.append('file', file);
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/upload/images',
                    headers:{
                        'Content-Type': 'multipart/form-data',
                    },
                    data:params,
                    responseType:'json',
                }).then( res => {
                    this.imgUrl = res.data.data.thumbnailUrl;
                    this.$Spin.hide();
                    // console.log(res.data);
                })
            },
            delImg(){
                this.imgUrl = '';
                this.add.picture = '';
            },
            bigImg(imgUrl){
                this.bigImgMsg = imgUrl;
                if (this.bigImgMsg) {
                    this.bigImgList = true;
                }
            },
            info (nodesc) {
                this.$Notice.info({
                    title: '友情提示',
                    desc: nodesc ? '' : this.notice,
                });
            },
            success (nodesc) {
                this.$Notice.success({
                    title: '成功提示',
                    desc: nodesc ? '' : this.notice,
                });
            },
            warning (nodesc) {
                this.$Notice.warning({
                    title: '警告',
                    desc: nodesc ? '' : this.notice,
                });
            },
            error (nodesc) {
                this.$Notice.error({
                    title: '错误',
                    desc: nodesc ? '' : this.notice,
                    duration: 0
                });
            },
            handleSpinCustom () {
                this.$Spin.show({
                    render: (h) => {
                        return h('div', [
                            h('Icon', {
                                'class': 'demo-spin-icon-load',
                                props: {
                                    type: 'ios-loading',
                                    size: 18
                                }
                            }),
                            h('div', 'Loading')
                        ])
                    }
                });
            },
            local(uri,id){
                this.active = uri;
                if (id === '') {
                    this.$router.push({path:'/'+uri});
                } else {
                    this.$router.push({path:'/'+uri,query:{id:id}});
                }
            },
        }
    }
</script>

<style scoped>
    .cl{
        clear: both;
        content: '';
        display: table;
    }
    .add{
        padding: 20px;
        text-align: center;
    }
    .add .container{
        background: #fff;
    }
    ul{
        margin: 0;
        padding: 0;
    }
    li{
        list-style: none;
    }
    td{
        overflow: hidden !important;
    }
    textarea{
        resize: none !important;
    }
    select{
        padding-left: 15px !important;
    }
    .forms{
        display: inline-block;
    }
    .demo-table .demo-table-expand .el-form-item {
        text-align: initial;
        width: 100% !important;
    }
</style>
