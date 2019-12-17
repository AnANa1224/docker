<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>导航菜单管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="detail">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="local('navigation')" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">详情</div>
                            <div class="el-page-header__content">
                                <button @click="local('editNav',navMsg.id)" type="button" class="el-button el-button--primary is-circle" style="padding: 3px;">
                                    <i class="el-icon-edit"></i>
                                </button>
                                <button @click="modal1 = true" type="button" class="el-button el-button--danger is-circle" style="padding: 3px;">
                                    <i class="el-icon-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="demo-block demo-zh-CN demo-table">
                    <h3 style="margin: 55px 0 20px;">导航信息</h3>
                    <form class="el-form demo-table-expand el-form--label-left el-form--inline ma" style="width: 20%;min-width: 300px;">
                        <div class="el-form-item">
                            <label class="el-form-item__label">菜单类型</label>
                            <div class="el-form-item__content">
                                <span v-if="navMsg.type_id === 1">导航</span>
                                <span v-if="navMsg.type_id === 2">广告</span>
                                <span v-if="navMsg.type_id === 3">大图</span>
                                <span v-if="navMsg.type_id === 4">小图</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">标题</label>
                            <div class="el-form-item__content">
                                <span>{{navMsg.title}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">链接类型</label>
                            <div class="el-form-item__content">
                                <span v-if="navMsg.link_type === 1">商品分类页</span>
                                <span v-if="navMsg.link_type === 2">商品购买页</span>
                                <span v-if="navMsg.link_type === 3">商品活动页</span>
                                <span v-if="navMsg.link_type === 4">店铺页</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">链接目标</label>
                            <div class="el-form-item__content">
                                <span v-for="target in targets" v-if="target.id === navMsg.link_target">{{target.name}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">排序</label>
                            <div class="el-form-item__content">
                                <span>{{navMsg.sort}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">状态</label>
                            <div class="el-form-item__content">
                                <span v-if="navMsg.status === 1">显示</span>
                                <span v-else-if="navMsg.status === 2">隐藏</span>
                                <span v-else-if="navMsg.status === 3">已删</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">创建时间</label>
                            <div class="el-form-item__content">
                                <span>{{navMsg.created_at}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">上次修改</label>
                            <div class="el-form-item__content">
                                <span>{{navMsg.updated_at}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">图片信息</label>
                            <div class="el-form-item__content">
                                <img @click="bigImg(imgUrl)" :src="imgUrl" alt="" style="max-width: 500px;cursor: pointer;">
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
        <!--  删除确认弹框-->
        <Modal v-model="modal1" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>确认删除</span>
            </p>
            <div style="text-align:center">
                <p>您确定要删除该条信息吗?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="del">删除</Button>
            </div>
        </Modal>

    </div>
    <!-- END MAIN -->
</template>

<script>
    export default {
        name: "DetailNav",
        data() {
            return {
                id:Number,
                apiUrl:'',
                targets:[],
                navMsg:{},
                imgUrl:'',
                bigImgList:false,
                bigImgMsg:{},
                notice:'',
                modal1: false, // 确认弹框
                modal_loading: false,
            }
        },
        mounted() {
            this.id = this.$route.query.id;
            this.apiUrl = global.origin;
            this.navDetail(this.id);
        },
        methods: {
            navDetail(id){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/nav/detail',
                    params:{
                        id:id
                    },
                    responseType:'json'
                }).then( res => {
                    if (res.data.code === 0){
                        this.navMsg = res.data.data;
                        this.imgUrl = res.data.data.picture;
                        this.targrtDetail();
                    }
                })
            },
            targrtDetail(){
                if (this.navMsg.link_type === 1) {
                    axios({
                        method: 'get',
                        url: this.apiUrl+'/api/category',
                        responseType: 'json'
                    }).then( res => {
                        this.targets = res.data.data;
                        this.$Spin.hide();
                    })
                } else if (this.navMsg.link_type === 2) {
                    axios({
                        method: 'get',
                        url: this.apiUrl+'/api/product',
                        responseType: 'json'
                    }).then( res => {
                        this.targets = res.data.data;
                        this.$Spin.hide();
                    })
                } else if (this.navMsg.link_type === 3) {
                    this.navMsg.link_target = -1;
                    this.targets = [{id:-1,name:'暂无活动'}];
                    this.$Spin.hide();
                } else if (this.navMsg.link_type === 4) {
                    this.navMsg.link_target = -1;
                    this.targets = [{id:-1,name:'暂无店铺'}];
                    this.$Spin.hide();
                }
            },
            del(){
                this.modal_loading = true;
                this.delNav();
            },
            delNav(){
                this.modal_loading = true;
                axios({
                    method: 'delete',
                    url: this.apiUrl+'/api/nav/delete',
                    params:{
                        id:this.id,
                    },
                    responseType:'json'
                }).then( res=> {
                    this.notice = res.data.msg;
                    if (res.data.code === 0) {
                        this.success(false);
                        this.local('navigation');
                    } else {
                        this.error(false);
                    }
                    this.modal1 = false;
                    this.modal_loading = false;
                })
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
    .detail{
        padding: 20px;
        text-align: center;
    }
    .detail .container{
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
