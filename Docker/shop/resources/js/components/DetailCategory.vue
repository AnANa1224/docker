<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>分类管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="detail">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="local('')" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">分类详情</div>
                            <div class="el-page-header__content">
                                <button @click="local('editCategory',cateMsg.id)" type="button" class="el-button el-button--primary is-circle" style="padding: 3px;">
                                    <i class="el-icon-edit"></i>
                                </button>
                                <button @click="modal1 = true" type="button" class="el-button el-button--danger is-circle" style="padding: 3px;">
                                    <i class="el-icon-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forms">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;text-align:left;">分类名称</label>
                            <label class="el-form-item__label" style="width: 80px;">{{cateMsg.name}}</label>
                        </div>
                        <div v-if="attrList" class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;text-align:left;">已有属性</label>
                            <label class="el-form-item__label">
                                <span v-if="attr1" class="el-tag el-tag--info el-tag--light">{{attr1}}</span>
                                <span v-if="attr2" class="el-tag el-tag--info el-tag--light">{{attr2}}</span>
                                <span v-if="attr3" class="el-tag el-tag--info el-tag--light">{{attr3}}</span>
                            </label>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;text-align:left;">分类排序</label>
                            <label class="el-form-item__label" style="width: 80px;">{{cateMsg.sort}}</label>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;text-align:left;">分类状态</label>
                            <label class="el-form-item__label" style="width: 80px;">{{cateMsg.status}}</label>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;text-align:left;">创建时间</label>
                            <label class="el-form-item__label">{{cateMsg.created_at}}</label>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;text-align:left;">上次修改</label>
                            <label class="el-form-item__label">{{cateMsg.updated_at}}</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--  删除确认弹框-->
        <Modal v-model="modal1" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>确认删除</span>
            </p>
            <div style="text-align:center">
                <p>这将影响到该分类下的所有商品。</p>
                <p>是否继续删除？</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="del">删除</Button>
            </div>
        </Modal>

    </div>
    <!-- END MAIN -->
</template>

<script>
    import axios from "axios";

    export default {
        name: "DetailCategory",
        data() {
            return {
                apiUrl:'',
                attr1:'',
                attr2:'',
                attr3:'',
                attrList:false,
                cateMsg:{},
                notice:'',  // 提示信息
                id:Number,
                modal1: false, // 确认弹框
                modal_loading: false, // 加载ing
            }
        },
        mounted() {
            this.apiUrl = global.origin;
            this.id = this.$route.query.id;
            this.cateDetail(this.id);
        },
        methods: {
            cateDetail(id){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/category/detail',
                    params:{
                        id:id,
                    },
                    responseType:'json'
                }).then(res => {
                    // console.log(res.data.data);
                    if (res.data.code === 0) {
                        this.cateMsg = res.data.data;
                        if (this.cateMsg.property.attr1){
                            this.attrList = true;
                            this.attr1 = this.cateMsg.property.attr1;
                            this.attr2 = this.cateMsg.property.attr2 ? this.cateMsg.property.attr2 : '';
                            this.attr3 = this.cateMsg.property.attr3 ? this.cateMsg.property.attr3 : '';
                        }
                    } else {
                        this.notice = res.data.msg;
                        this.error(false);
                    }
                    this.$Spin.hide();
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
            del(){
                this.modal_loading = true;
                this.delCate();
            },
            delCate(){
                this.enterAlert = false;
                axios({
                    method:'delete',
                    url:this.apiUrl+'/api/category/delete',
                    params:{
                        id:this.id,
                    },
                    responseType:'json'
                }).then(res => {
                    this.modal_loading = false;
                    this.modal1 = false;
                    this.notice = res.data.msg;
                    if (res.data.code === 0){
                        this.success(false);
                        this.local('');
                    } else {
                        this.error(false);
                    }
                });
            },
            success (nodesc) {
                this.$Notice.success({
                    title: '成功提示',
                    desc: nodesc ? '' : this.notice,
                });
            },
            error (nodesc) {
                this.$Notice.error({
                    title: '错误',
                    desc: nodesc ? '' : this.notice,
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
        }
    }
</script>

<style scoped>
    .detail{
        padding: 20px;
        text-align: center;
    }
    .detail .container{
        background: #fff;
    }
    .forms{
        display: inline-block;
    }

</style>
