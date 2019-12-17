<template>
    <div class="main">
        <div class="container">
            <div class="main-content-head">
                <h2>分类管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>
        <div class="add">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="local('')" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">新增分类</div>
                        </div>
                    </div>
                </div>
                <div class="forms">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">分类名称</label>
                            <input v-model="name" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请输入分类名">
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
                            <select v-model.number="sort" name="sort" id="sort" style="width: 300px; height: 40px">
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
                            <select v-model.number="status" name="status" id="status" style="width: 300px; height: 40px">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <button type="button" class="el-button el-button--primary" @click="addCate"><span>立即创建</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CreateCategory",
        data() {
            return {
                apiUrl:'',
                cateAttrs:[],
                attrList:false,
                disabled:true,
                name:'',
                attr:'',
                attr1:'',
                attr2:'',
                attr3:'',
                sort:10,
                status:1,
                notice:'',  // 提示信息
                modal_loading: false, // 加载ing
            }
        },
        mounted() {
            this.apiUrl = global.origin;
        },
        methods: {
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
            addCate(){
                this.handleSpinCustom();
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/category/create',
                    params:{
                        name:this.name,
                        attr1:this.attr1,
                        attr2:this.attr2,
                        attr3:this.attr3,
                        sort:this.sort,
                        status:this.status,
                    },
                    responseType:'json',
                }).then(res => {
                    this.notice = res.data.msg;
                    if (res.data.code === 0) {
                        this.success(false);
                        this.name = '';
                        this.attr = '';
                        this.attr1 = '';
                        this.attr2 = '';
                        this.attr3 = '';
                        this.sort = 10;
                        this.status = 1;
                        this.attrList = false;
                    } else {
                        this.error(false);
                    }
                    this.$Spin.hide();
                });
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
            },
            local(uri){
                this.active = uri;
                this.$router.push({path:'/'+uri});
            }
        }
    }
</script>

<style scoped>
    .add{
        padding: 20px;
        text-align: center;
    }
    .add .container{
        background: #fff;
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
    .forms{
        display: inline-block;
    }
</style>
