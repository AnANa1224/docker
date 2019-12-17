<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>分类管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="edit">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="local('')" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">更新分类</div>
                            <div class="el-page-header__content">
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
                            <label class="el-form-item__label" style="width: 80px;">分类名称</label>
                            <input v-model="cateMsg.name" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请输入分类名称">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">分类属性</label>
                            <input v-if="attr1 == false" v-model="attr" type="text" autocomplete="off" style="width: 150px; float: left" class="el-input__inner" placeholder="主属性">
                            <input v-else v-model="attr" type="text" autocomplete="off" style="width: 150px; float: left" class="el-input__inner" placeholder="属性">
                            <p class="addAttr" @click="addAttr">添加属性</p>
                        </div>
                        <div v-if="attrList" class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">已有属性</label>
                            <ul class="attrs">
                                <li v-if="attr1" class="attr">
                                    {{attr1}} (主)
                                    <span @click="removeAttr('attr1')">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                </li>
                                <li v-if="attr2" class="attr">
                                    {{attr2}}
                                    <span @click="removeAttr('attr2')">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                </li>
                                <li v-if="attr3" class="attr">
                                    {{attr3}}
                                    <span @click="removeAttr('attr3')">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                </li>
                            </ul>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">分类排序</label>
                            <select v-model="cateMsg.sort" name="sort" id="edit_sort" style="width: 300px; height: 40px">
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
                            <label class="el-form-item__label" style="width: 80px;">分类状态</label>
                            <select v-model="cateMsg.status" name="status" id="edit_status" style="width: 300px; height: 40px">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <button type="button" class="el-button el-button--primary" @click="editCate"><span>更新</span></button>
                            </div>
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
        name: "EditCategory",
        data () {
            return {
                id:'',
                apiUrl:'',
                attrList:false,
                attr:'',
                attr1:'',
                attr2:'',
                attr3:'',
                cateMsg:{},
                notice:'',  // 提示信息
                modal1: false, // 确认弹框
                modal_loading: false, // 加载ing
            };
        },
        mounted(){
            this.id = this.$route.query.id;
            this.apiUrl = global.origin;
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
            addAttr(){
                if (this.attr.length <= 0) {
                    this.notice = '属性不能为空';
                    this.info(false);
                    return;
                }
                if (!this.attr1) {
                    this.attr1 = this.attr;
                    this.attrList = true;
                    this.attr = '';
                    return false;
                } else if(!this.attr2) {
                    if (this.attr1 === this.attr){
                        this.notice = '已有该属性';
                        this.error(false);
                        return;
                    }
                    this.attr2 = this.attr;
                    this.attrList = true;
                    this.attr = '';
                    return false;
                } else if(!this.attr3) {
                    if (this.attr1 === this.attr || this.attr2 === this.attr){
                        this.notice = '已有该属性';
                        this.error(false);
                        return;
                    }
                    this.attr3 = this.attr;
                    this.attrList = true;
                    this.attr = '';
                    return false;
                } else if (this.attr1 && this.attr2 && this.attr3){
                    this.notice = '属性已达上限';
                    this.error(false);
                    return false;
                }
            },
            removeAttr(attr){
                if (attr === 'attr1') {
                    this.attr1 = '';
                    if (this.attr2) {
                        this.attr1 = this.attr2;
                        if (this.attr3) {
                            this.attr2 = this.attr3;
                            this.attr3 = '';
                        } else {
                            this.attr2 = '';
                        }
                    } else {
                        this.attrList = false;
                    }
                }
                if (attr === 'attr2') {
                    this.attr2 = '';
                    if (this.attr3) {
                        this.attr2 = this.attr3;
                        this.attr3 = '';
                    }
                }
                if (attr === 'attr3') {
                    this.attr3 = '';
                }
            },
            editCate(){
                this.handleSpinCustom();
                axios({
                    method:'put',
                    url:this.apiUrl+'/api/category/update',
                    params:{
                        id:this.cateMsg.id,
                        name:this.cateMsg.name,
                        attr1:this.attr1,
                        attr2:this.attr2,
                        attr3:this.attr3,
                        sort:this.cateMsg.sort,
                        status:this.cateMsg.status,
                    },
                    responseType:'json',
                }).then(res => {
                    // console.log(res.data);
                    this.notice = res.data.msg;
                    if (res.data.code === 0) {
                        this.success(false);
                    } else {
                        this.error(false);
                    }
                    this.$Spin.hide();
                });
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
            local(uri,id){
                this.active = uri;
                if (id === '') {
                    this.$router.push({path:'/'+uri});
                } else {
                    this.$router.push({path:'/'+uri,query:{id:id}});
                }
            },
            confirmAlert(notice,id){
                this.notice = notice;
                this.cate_id = id;
                this.enterAlert = true;
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
            }
        }
    }
</script>

<style scoped>
    .edit{
        padding: 20px;
        text-align: center;
    }
    .edit .container{
        background: #fff;
    }
    .forms{
        display: inline-block;
    }
    .addAttr{
        display: inline-block;
        padding: 0 10px;
        cursor: pointer;
        line-height: 40px;
        background: #f6f6f6;
        border-radius: 10px;
        margin-left: 20px;
    }
    .attrs{
        float: left;
        height: 40px;
        padding-top: 5px;
    }
    .attr{
        float: left;
        line-height: 20px;
        padding: 5px 20px;
        border-radius: 20px;
        background: #fff;
        margin-left: 10px;
    }
</style>
