<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>商品管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="add">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div @click="local('product')" class="el-page-header">
                            <div class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">添加商品</div>
                        </div>
                    </div>
                </div>
                <div class="source" style="text-align: initial;padding: 0 10px;border-bottom: 1px solid #eee;">
                    <div>
                        <div class="el-steps el-steps--horizontal">
                            <div class="el-step is-horizontal" style="flex-basis: 50%; margin-right: 0px;">
                                <div class="el-step__head" :class="first_stepsClass">
                                    <div class="el-step__line" style="margin-right: 0px;">
                                        <i class="el-step__line-inner" style="width: 100%" :style="first_bar"></i>
                                    </div>
                                    <div class="el-step__icon is-text">
                                        <i v-if="first_status" class="el-step__icon-inner is-status el-icon-check"></i>
                                        <div v-else class="el-step__icon-inner">1</div>
                                    </div>
                                </div>
                                <div class="el-step__main">
                                    <div class="el-step__title" :class="first_stepsClass">填写商品信息</div>
                                    <div class="el-step__description" :class="first_stepsClass"></div>
                                </div>
                            </div>
                            <div class="el-step is-horizontal" style="flex-basis: 50%; margin-right: 0px;">
                                <div class="el-step__head" :class="second_stepsClass">
                                    <div class="el-step__line" style="margin-right: 0px;">
                                        <i class="el-step__line-inner" style="width: 100%" :style="second_bar"></i>
                                    </div>
                                    <div class="el-step__icon is-text">
                                        <i v-if="second_status" class="el-step__icon-inner is-status el-icon-check"></i>
                                        <div v-else class="el-step__icon-inner">2</div>
                                    </div>
                                </div>
                                <div class="el-step__main">
                                    <div class="el-step__title" :class="second_stepsClass">填写库存信息</div>
                                    <div class="el-step__description" :class="second_stepsClass"></div>
                                </div>
                            </div>
                            <div class="el-step is-horizontal" style="flex-basis: 50%; margin-right: 0px;">
                                <div class="el-step__head" :class="third_stepsClass">
                                    <div class="el-step__line" style="margin-right: 0px;">
                                        <i class="el-step__line-inner" style="width: 100%" :style="third_bar"></i>
                                    </div>
                                    <div class="el-step__icon is-text">
                                        <i v-if="third_status" class="el-step__icon-inner is-status el-icon-check"></i>
                                        <div v-else class="el-step__icon-inner">3</div>
                                    </div>
                                </div>
                                <div class="el-step__main">
                                    <div class="el-step__title" :class="third_stepsClass">填写附加信息</div>
                                    <div class="el-step__description" :class="third_stepsClass"></div>
                                </div>
                            </div>
                            <div class="el-step is-horizontal is-flex" style="flex-basis: 50%; max-width: 33.3333%;">
                                <div class="el-step__head" :class="last_stepsClass">
                                    <div class="el-step__line">
                                        <i class="el-step__line-inner"></i>
                                    </div>
                                    <div class="el-step__icon is-text">
                                        <i v-if="last_status" class="el-step__icon-inner is-status el-icon-check"></i>
                                        <div v-else class="el-step__icon-inner">4</div>
                                    </div>
                                </div>
                                <div class="el-step__main">
                                    <div class="el-step__title" :class="last_stepsClass">完成</div>
                                    <div class="el-step__description" :class="last_stepsClass"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="step === 'first'" class="forms">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品名称</label>
                            <input v-model="name" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请输入商品名称">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品分类</label>
                            <select v-model.number="category_id" name="cate" id="cate" style="width: 300px; height: 40px">
                                <option value="">请选择</option>
                                <option v-for="category in categorys" :value="category.id">{{category.name}}</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品排序</label>
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
                            <label class="el-form-item__label" style="width: 80px;">商品状态</label>
                            <select v-model.number="status" name="status" id="status" style="width: 300px; height: 40px">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品描述</label>
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <div class="el-textarea">
                                    <textarea v-model="content" autocomplete="off" class="el-textarea__inner" style="min-height: 33px;" placeholder="请输入描述"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <button type="button" class="el-button el-button--primary" style="width: 300px;" @click="addPro"><span>立即创建</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div v-else-if="step === 'second'" class="forms" style="width: 80%;">
                    <form class="el-form">
                        <div class="el-form-item">
                            <h3 class="sku_title"><span>商品名称</span></h3>
                            <div class="sku_attr"><span>{{proMsg.name}}</span></div>
                        </div>
                        <div class="el-form-item">
                            <h3 class="sku_title"><span>商品分类</span></h3>
                            <div class="sku_attr"><span>{{cateMsg.name}}</span></div>
                        </div>
                        <div v-if="attr1" class="el-form-item">
                            <h3 class="sku_title"><span>{{attr1}}</span></h3>
                            <div class="sku_attr">
                                <span v-for="(a,index) in attrs1" class="el-tag el-tag--dark">{{a.attr1}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr1',index)"></i></span>
                                <input v-model="sku_attrs1.attr1" type="text" autocomplete="off" placeholder="属性名" class="el-input__inner" style="width: 80px;">
                                <span @click="addSkuAttr1" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                            </div>
                        </div>
                        <div v-if="attr2" class="el-form-item">
                            <h3 class="sku_title"><span>{{attr2}}</span></h3>
                            <div class="sku_attr">
                                <span v-for="(a,index) in attrs2" class="el-tag el-tag--dark">{{a.attr2}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr2',index)"></i></span>
                                <input v-model="sku_attrs2.attr2" type="text" autocomplete="off" placeholder="属性名" class="el-input__inner" style="width: 80px;">
                                <span @click="addSkuAttr2" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                            </div>
                        </div>
                        <div v-if="attr3" class="el-form-item">
                            <h3 class="sku_title"><span>{{attr3}}</span></h3>
                            <div class="sku_attr">
                                <span v-for="(a,index) in attrs3" class="el-tag el-tag--dark">{{a.attr3}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr3',index)"></i></span>
                                <input v-model="sku_attrs3.attr3" type="text" autocomplete="off" placeholder="属性名" class="el-input__inner" style="width: 80px;">
                                <span @click="addSkuAttr3" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                            </div>
                        </div>
                        <div v-if="skuMsg.length > 0" class="source" style="display:inline-block;margin-bottom: 100px;">
                            <h3 style="margin: 55px 0 20px;">商品属性库存信息</h3>
                            <div>
                                <div class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 325px;">
                                    <div class="hidden-columns">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                    <div class="el-table__header-wrapper">
                                        <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 802px;">
                                            <thead class="has-gutter">
                                            <tr class="">
                                                <th v-if="attr1" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr1}}</div></th>
                                                <th v-if="attr2" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr2}}</div></th>
                                                <th v-if="attr3" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr3}}</div></th>
                                                <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">单价</div></th>
                                                <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">售价</div></th>
                                                <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">库存</div></th>
                                                <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">排序</div></th>
                                                <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">状态</div></th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="el-table__body-wrapper is-scrolling-none" style="height: 267px;">
                                        <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                            <tbody>
                                            <tr v-for="(sku,index) in skuMsg" class="el-table__row">
                                                <td v-if="attr1" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr1}}</div></td>
                                                <td v-if="attr2" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr2}}</div></td>
                                                <td v-if="attr3" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr3}}</div></td>
                                                <td rowspan="1" colspan="1" class="sky_item">
                                                    <div class="cell">
                                                        <input v-model.number="sku.original_price" type="text" autocomplete="off" style="width: 80%;" class="el-input__inner" placeholder="单价">
                                                    </div>
                                                </td>
                                                <td rowspan="1" colspan="1" class="sky_item">
                                                    <div class="cell">
                                                        <input v-model.number="sku.price" type="text" autocomplete="off" style="width: 80%;" class="el-input__inner" placeholder="售价">
                                                    </div>
                                                </td>
                                                <td rowspan="1" colspan="1" class="sky_item">
                                                    <div class="cell">
                                                        <input v-model.number="sku.quantity" type="text" autocomplete="off" style="width: 80%;" class="el-input__inner" placeholder="库存">
                                                    </div>
                                                </td>
                                                <td rowspan="1" colspan="1" class="sky_item">
                                                    <div class="cell">
                                                        <select v-model.number="sku.sort" name="sort" style="width: 80%; height: 40px">
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
                                                </td>
                                                <td rowspan="1" colspan="1" class="sky_item">
                                                    <div class="cell">
                                                        <select v-model.number="sku.status" name="status" style="width: 80%; height: 40px">
                                                            <option value="1">显示</option>
                                                            <option value="2">隐藏</option>
                                                            <option value="3">删除</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="el-table__column-resize-proxy" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <div class="el-form-item__content">
                                <button @click="addSkus" type="button" class="el-button el-button--primary" style="width: 300px;"><span>保存</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div v-else-if="step === 'third'"  class="tags">
                    <h3 id="title" class="tac" style="margin: 0 20px;">
                        商品附加标签信息
                        <a id="skip" class="el-link el-link--warning is-underline">
                            <span @click="steps('third')" class="el-link--inner">跳过这一步</span>
                        </a>
                    </h3>
                    <form class="el-form">
                        <div class="el-form-item">
                            <h3 id="zhao-pian-qiang" style="margin: 30px 0 10px;">商品图片信息</h3>
                            <div class="source">
                                <div>
                                    <div>
                                        <ul class="el-upload-list el-upload-list--picture-card">
                                            <li v-if="imgUrls" v-for="(img,index) in imgUrls" tabindex="0" class="el-upload-list__item is-success">
                                                <img :src="img" alt="" class="el-upload-list__item-thumbnail">
                                                <label class="el-upload-list__item-status-label">
                                                    <i class="el-icon-upload-success el-icon-check"></i>
                                                </label>
                                                <i class="el-icon-close"></i>
                                                <i class="el-icon-close-tip">按 delete 键可删除</i>
                                                <span class="el-upload-list__item-actions">
                                                    <span @click="bigImg(img)" class="el-upload-list__item-preview">
                                                            <i class="el-icon-zoom-in"></i>
                                                        </span>
                                                    <span @click="delImg(index)" class="el-upload-list__item-delete">
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
                                    <div v-if="bigImgList" class="el-dialog__wrapper" style="z-index: 2052">
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
                                </div>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <h3 id="shu-ru-chang-du-xian-zhi" style="margin: 30px 0 10px;">商品宣传语　( 选填 )</h3>
                            <div class="el-textarea">
                                <textarea v-model="tag_content" autocomplete="off" placeholder="请输入内容" maxlength="3000" class="el-textarea__inner" style="width: 50%;min-width:390px;min-height: 70px;"></textarea>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <h3 id="bao-zhi-qi" style="margin: 30px 0 10px;">商品保质期</h3>
                            <select v-model.number="tag_lift" name="status" id="lift" style="width: 300px; height: 40px">
                                <option value="">按需选择 (可不选)</option>
                                <option value="30">30天</option>
                                <option value="45">45天</option>
                                <option value="90">3个月</option>
                                <option value="180">6个月</option>
                                <option value="360">1年</option>
                                <option value="-1">自定义</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <div class="el-form-item__content tac" style="margin-top: 40px;">
                                <button type="button" class="el-button el-button--primary" @click="addTags" style="width: 200px;">
                                    <span>保存</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div v-else-if="step === 'last'" style="padding: 50px 0;">
                    <h2 style="padding: 20px 0 30px;">恭喜你,添加成功了</h2>
                    <img src="/assets/images/s.jpg" alt="">
                </div>
            </div>
        </div>

        <!--  大图遮罩层  -->
        <div v-if="bigImgList" class="v-modal" tabindex="0" style="z-index: 2051;"></div>
    </div>
    <!-- END MAIN -->
</template>

<script>
    import axios from "axios";

    export default {
        name: "CreateProduct",
        data() {
            return {
                id:Number,
                apiUrl:'',
                categorys:[],
                skusList:false,
                proMsg:{},
                cateMsg:{},
                // 分类数据
                attr1:'',
                attr2:'',
                attr3:'',
                // 添加商品数据
                name:'',
                category_id:'',
                sort:10,
                status:1,
                content:'',
                // 添加库存数据
                product_id:Number,
                original_price:'',
                price:'',
                quantity:'',
                skuMsg:[],
                skus:[],
                sku:{},
                sku_attrs1:{product_id:null,attr1:'',original_price:null,price:null,quantity:null,sort:10,status:1},
                attrs1:[],
                sku_attrs2:{attr2:''},
                attrs2:[],
                sku_attrs3:{attr3:''},
                attrs3:[],
                // 进度条
                step:'first',
                first_stepsClass:'is-process',
                first_bar:'border-width: 0px;',
                first_status:false,
                second_stepsClass:'is-wait',
                second_bar:'border-width: 0px;',
                second_status:false,
                third_stepsClass:'is-wait',
                third_bar:'border-width: 0px;',
                third_status:false,
                last_stepsClass:'is-wait',
                last_status:false,
                notice:'',  // 提示信息
                tag_content:'',
                tag_lift:'',
                imgUrls:[],
                files:[],
                bigImgList:false,
                bigImgMsg:{},
            }
        },
        mounted() {
            this.apiUrl = global.origin;
            this.getCateMes();
        },
        methods: {
            getCateMes(){
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/category',
                    responseType:'json'
                }).then(res => {
                    if (res.data.code === 0) {
                        // console.log(res.data.data);
                        this.categorys = res.data.data;
                    } else {

                    }
                });
            },
            steps(step) {
                if (step === 'first'){
                    this.first_stepsClass = 'is-success';
                    this.first_bar = 'border-width: 1px;';
                    this.first_status = true;
                    this.second_stepsClass = 'is-process';
                    this.step = 'second';
                } else if (step === 'second') {
                    this.second_stepsClass = 'is-success';
                    this.second_bar = 'border-width: 1px;';
                    this.second_status = true;
                    this.third_stepsClass = 'is-process';
                    this.step = 'third';
                } else if (step === 'third') {
                    this.third_stepsClass = 'is-success';
                    this.third_bar = 'border-width: 1px;';
                    this.third_status = true;
                    this.last_stepsClass = 'is-success';
                    this.last_status = true;
                    this.step = 'last';
                }
            },
            addPro(){
                this.handleSpinCustom();
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/product/create',
                    params:{
                        name:this.name,
                        category_id:this.category_id,
                        content:this.content,
                        sort:this.sort,
                        status:this.status,
                    },
                    responseType:'json',
                }).then(res => {
                    // console.log(res.data);
                    if (res.data.code === 0){
                        this.cateDetail(res.data.data);
                    } else {
                        this.notice = res.data.msg;
                        this.error(false);
                        this.$Spin.hide();
                    }

                });
            },
            cateDetail(data){
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/category/detail',
                    params:{
                        id:data.category_id,
                    },
                    responseType:'json'
                }).then( res => {
                    // console.log(res.data.data);
                    this.cateMsg = res.data.data;
                    this.proMsg = data;
                    // console.log(data);
                    this.proMsg.imgs ? this.imgUrls = this.proMsg.imgs : this.imgUrls = [];
                    this.product_id = data.id;
                    this.sku_attrs1.product_id = this.product_id;
                    if (this.proMsg.skus && this.proMsg.skus.length>0){
                        this.skusList = true;
                        this.skuMsg = this.proMsg.skus;
                        this.attrs1 = [];
                        this.attrs2 = [];
                        this.attrs3 = [];
                        let a1 = [];
                        let a2 = [];
                        let a3 = [];
                        for(let [index,sku] of this.skuMsg.entries()) {
                            if (sku.attr1 !== '') {
                                a1.push(sku.attr1);
                            }
                            if (sku.attr2 !== '') {
                                a2.push(sku.attr2);
                            }
                            if (sku.attr3 !== '') {
                                a3.push(sku.attr3);
                            }
                        }
                        a1 = Array.from(new Set(a1));
                        // console.log(a1);
                        for (let attr of a1){
                            this.attrs1.push({product_id:this.product_id,attr1:attr,original_price:0.00,price:0.00,quantity:0,sort:10,status:1});
                        }
                        a2 = Array.from(new Set(a2));
                        for (let attr of a2){
                            this.attrs2.push({attr2:attr});
                        }
                        a3 = Array.from(new Set(a3));
                        for (let attr of a3){
                            this.attrs3.push({attr3:attr});
                        }
                    }
                    if (this.cateMsg.property.attr1){
                        this.attr1 = this.cateMsg.property.attr1;
                        this.attr2 = this.cateMsg.property.attr2 ? this.cateMsg.property.attr2 : '';
                        this.attr3 = this.cateMsg.property.attr3 ? this.cateMsg.property.attr3 : '';
                    }
                    this.steps('first');
                    this.$Spin.hide();
                });
            },
            addSkuAttr1(){
                if (this.attr1 && this.sku_attrs1.attr1 === '') {
                    this.notice = this.attr1+'属性不能为空';
                    this.warning(false);
                    return false;
                }
                for (let at1 of this.attrs1){
                    if (at1.attr1 === this.sku_attrs1.attr1){
                        this.notice = '已有该属性';
                        this.warning(false);
                        return false;
                    }
                }
                this.attrs1.push(this.sku_attrs1);
                if (this.attr1 && !this.attr2 && !this.attr3) {
                    this.skuMsg.push(this.sku_attrs1);
                }
                if (this.attrs1.length>0 && this.attrs2.length>0 && this.attr3 === '') {
                    for (let a2 of this.attrs2) {
                        let sku = {};
                        sku.product_id = this.sku_attrs1.product_id;
                        sku.original_price = this.sku_attrs1.original_price;
                        sku.price = this.sku_attrs1.price;
                        sku.attr1 = this.sku_attrs1.attr1;
                        sku.attr2 = a2.attr2;
                        sku.quantity = 0;
                        sku.sort = this.sku_attrs1.sort;
                        sku.status = this.sku_attrs1.status;
                        this.skuMsg.push(sku);
                    }
                } else if (this.attrs1.length>0 && this.attrs2.length>0 && this.attrs3.length>0) {
                    for (let a2 of this.attrs2) {
                        for (let a3 of this.attrs3) {
                            let sku = {};
                            sku.product_id = this.sku_attrs1.product_id;
                            sku.original_price = this.sku_attrs1.original_price;
                            sku.price = this.sku_attrs1.price;
                            sku.attr1 = this.sku_attrs1.attr1;
                            sku.attr2 = a2.attr2;
                            sku.attr3 = a3.attr3;
                            sku.quantity = 0;
                            sku.sort = this.sku_attrs1.sort;
                            sku.status = this.sku_attrs1.status;
                            this.skuMsg.push(sku);
                        }
                    }
                }
                this.sku_attrs1 = {product_id:this.product_id,attr1:'',original_price:'',price:'',quantity:'',sort:10,status:1};
                this.skusList = true;
            },
            addSkuAttr2(){
                if (this.attrs1.length===0){
                    this.notice = '请至少先填写一条主属性';
                    this.warning(false);
                    this.sku_attrs2 = {attr2:''};
                    this.addAttr2Alert = false;
                    return false;
                }
                if (this.attr2 && this.sku_attrs2.attr2 === '') {
                    this.notice = this.attr2+'属性不能为空';
                    this.warning(false);
                    return false;
                }
                for (let at2 of this.attrs2){
                    if (at2.attr2 === this.sku_attrs2.attr2){
                        this.notice = '已有该属性';
                        this.warning(false);
                        this.addAttr2Alert = false;
                        return false;
                    }
                }
                this.attrs2.push(this.sku_attrs2);
                if (this.attrs1.length>0 && this.attrs2.length>0 && this.attr3 === '') {
                    for (let a1 of this.attrs1) {
                        let sku = {};
                        sku.product_id = this.product_id;
                        sku.original_price = a1.original_price;
                        sku.price = a1.price;
                        sku.attr1 = a1.attr1;
                        sku.attr2 = this.sku_attrs2.attr2;
                        sku.quantity = 0;
                        sku.sort = a1.sort;
                        sku.status = a1.status;
                        this.skuMsg.push(sku);
                    }
                } else if (this.attrs1.length>0 && this.attrs2.length>0 && this.attrs3.length>0) {
                    for (let a1 of this.attrs1) {
                        for (let a3 of this.attrs3) {
                            let sku = {};
                            sku.product_id = this.product_id;
                            sku.original_price = a1.original_price;
                            sku.price = a1.price;
                            sku.attr1 = a1.attr1;
                            sku.attr2 = this.sku_attrs2.attr2;
                            sku.attr3 = a3.attr3;
                            sku.quantity = 0;
                            sku.sort = a1.sort;
                            sku.status = a1.status;
                            this.skuMsg.push(sku);
                        }
                    }
                }
                this.sku_attrs2 = {attr2:''};
                this.addAttr2Alert = false;
                this.skusList = true;
            },
            addSkuAttr3(){
                if (this.attrs1.length===0){
                    this.notice = '请至少先填写一条主属性';
                    this.warning(false);
                    this.sku_attrs3 = {product_id:this.product_id,attr3:''};
                    this.addAttr3Alert = false;
                    return false;
                }
                if (this.attr3 && this.sku_attrs3.attr3 === '') {
                    this.notice = this.attr3+'属性不能为空';
                    this.warning(false);
                    this.addAttr2Alert = false;
                    return false;
                }
                for (let at3 of this.attrs3){
                    if (at3.attr3 === this.sku_attrs3.attr3){
                        this.notice = '已有该属性';
                        this.warning(false);
                        return false;
                    }
                }
                this.attrs3.push(this.sku_attrs3);
                if (this.attrs1.length>0 && this.attrs2.length>0) {
                    for (let a1 of this.attrs1) {
                        for (let a2 of this.attrs2) {
                            let sku = {};
                            sku.product_id = this.product_id;
                            sku.original_price = a1.original_price;
                            sku.price = a1.price;
                            sku.attr1 = a1.attr1;
                            sku.attr2 = a2.attr2;
                            sku.attr3 = this.sku_attrs3.attr3;
                            sku.quantity = 0;
                            sku.sort = a1.sort;
                            sku.status = a1.status;
                            this.skuMsg.push(sku);
                        }
                    }
                }
                this.sku_attrs3 = {product_id:this.product_id,attr3:''};
                this.addAttr3Alert = false;
                this.skusList = true;
            },
            delSkuAttr(attr,index){
                if (attr === 'attr1') {
                    let n = 2;
                    let max = this.attrs2.length * this.attrs3.length;
                    while (Math.pow(2,n) <= max) {
                        n++;
                    }
                    for (let i=0; i<n; i++) {
                        for(let [key,value] of this.skuMsg.entries()){
                            if (value.attr1 === this.attrs1[index].attr1) {
                                this.skuMsg.splice(key,1);
                            }
                        }
                    }
                    if (this.attrs1.length === 1) {
                        this.attrs1 = [];
                        this.attrs2 = [];
                        this.attrs3 = [];
                    } else {
                        this.attrs1.splice(index,1);
                    }
                } else if (attr === 'attr2') {
                    let n = 2;
                    let max = this.attrs1.length * this.attrs3.length;
                    while (Math.pow(2,n) <= max) {
                        n++;
                    }
                    for (let i=0; i<n; i++) {
                        for(let [key,value] of this.skuMsg.entries()){
                            if (value.attr2 === this.attrs2[index].attr2) {
                                this.skuMsg.splice(key,1);
                            }
                        }
                    }
                    this.attrs2.splice(index,1);
                } else if (attr === 'attr3') {
                    let n = 2;
                    let max = this.attrs1.length * this.attrs2.length;
                    while (Math.pow(2,n) <= max) {
                        n++;
                    }
                    for (let i=0; i<n; i++) {
                        for(let [key,value] of this.skuMsg.entries()){
                            if (value.attr3 === this.attrs3[index].attr3) {
                                this.skuMsg.splice(key,1);
                            }
                        }
                    }
                    this.attrs3.splice(index,1);
                }
            },
            tell(){
                if (this.attr1 && this.sku_attrs1.attr1 === '') {
                    this.notice = this.attr1+'属性不能为空';
                    this.warning(false);
                    return false;
                }
                if (this.sku_attrs1.original_price === '') {
                    this.notice = '单价不能为空';
                    this.warning(false);
                    return false;
                }
                if (this.sku_attrs1.price === '') {
                    this.notice = '售价不能为空';
                    this.warning(false);
                    return false;
                }
                if (this.sku_attrs1.quantity === '') {
                    this.notice = '库存不能为空';
                    this.warning(false);
                    return false;
                }
                return true;
            },
            tellSku(){
                if (this.sku.original_price === '') {
                    this.notice = '原价不能为空';
                    this.warning(false);
                    return false;
                }
                if (this.sku.price === '') {
                    this.notice = '售价不能为空';
                    this.warning(false);
                    return false;
                }
                if (this.sku.quantity === '') {
                    this.notice = '库存不能为空';
                    this.warning(false);
                    return false;
                }
                return true;
            },
            addSkus(){
                this.handleSpinCustom();
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/product/sku/create',
                    params:this.skuMsg,
                }).then(res => {
                    // console.log(res);
                    this.notice = res.data.msg;
                    if (res.data.code === 0){
                        this.steps('second');
                        this.success(false);
                    } else {
                        this.error(false);
                    }
                    this.$Spin.hide();
                });
            },
            addTags(){
                let params = {};
                if (this.imgUrls.length>0) {
                    let image_keys = this.imgUrls.join(',');
                    let tag1 = {
                        'product_id':this.product_id,
                        'tag_id':1,
                        'value':image_keys,
                        'status':1,
                    };
                    params.tag1 = tag1;
                } else{
                    this.notice = '请先上传图片';
                    this.warning(false);
                    return false;
                }
                let tag2 = {
                    'product_id':this.product_id,
                    'tag_id':2,
                    'value':this.tag_content,
                    'status':1,
                };
                params.tag2 = tag2;
                let tag3 = {
                    'product_id':this.product_id,
                    'tag_id':3,
                    'value':this.tag_lift,
                    'status':1,
                };
                params.tag3 = tag3;

                axios({
                    method:'post',
                    url:this.apiUrl+'/api/product/tag/create',
                    params:params,
                    responseType:'json'
                }).then( res => {
                    this.notice = res.data.msg;
                    if (res.data.code === 0) {
                        this.steps('third');
                        this.success(false);
                    } else {
                        this.error(false);
                    }
                })
            },
            uploadImg(e){
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
                    this.imgUrls.push(res.data.data.thumbnailUrl);
                    // console.log(res.data);
                })
            },
            delImg(index){
                this.imgUrls.splice(index,1);
            },
            delProImg(index){
                this.imgUrls.splice(index,1);
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
    select{
        padding-left: 15px !important;
    }
    .add{
        padding: 20px;
        text-align: center;
    }
    .add .container{
        background: #fff;
    }
    .forms{
        display: inline-block;
    }
    .sky_item{
        width: 80px;
        text-align: center !important;
    }
    .demo-table .demo-table-expand .el-form-item {
        text-align: initial;
        width: 100% !important;
    }
    .tags{
        padding: 30px 50px;
        text-align: initial !important;
    }
    #title{
        position: relative;
    }
    #skip{
        position: absolute;
        right: 0;
        top: 0;
    }
    .sku_title{
        line-height: 30px;
        margin: 20px 40px 10px 0;
        float: left;
        text-align: left;
        width: 120px;
    }
    .sku_attr{
        max-width: 400px;
        line-height: 30px;
        margin: 20px 40px 10px 0;
        float: left;
        text-align: left;
    }
    .el-tag{
        margin-right: 10px !important;
        margin-bottom: 10px !important;
    }
    .cp{
        cursor: pointer;
    }
    .el-message-box{
        width: 100% !important;
        max-width: 420px !important;
    }

</style>
