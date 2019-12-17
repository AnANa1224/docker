<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>商品管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div v-if="operation === 'show'" class="shows">
            <div class="container">
                <div class="box">
                    <div class="box-head">
                        <h2>所有商品信息</h2>
                        <p @click="local('createProduct')">添加商品</p>
                    </div>
                    <div class="item">
                        <div class="item-responsive ">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>商品名称</th>
                                    <th>商品分类</th>
                                    <th>商品状态</th>
                                    <th>相关操作</th>
                                </tr>
                                </thead><!--/thead-->
                                <tbody>
                                <tr v-for="(product,index) in products">
                                    <td>
                                        <a class="el-link el-link--success is-underline" @click="local('detailProduct',product.id)">
                                            <span class="el-link--inner">
                                                {{index+1}}
                                                <i class="el-icon-view el-icon--right"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{product.name}}</td>
                                    <td>{{product.category_name}}</td>
                                    <td>
                                        <span v-if="product.status === 1" class="item-status delivered">显示</span>
                                        <span v-if="product.status === 2" class="item-status cancel">隐藏</span>
                                    </td>
                                    <td>
                                        <span class="item-status delivered" @click="local('editProduct',product.id)">UPDATE</span>
                                        <span class="item-status cancel" @click="modal1 = true,product_id = product.id">DELETE</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="proPages.pageCount !== 1" class="demo-block demo-zh-CN demo-pagination">
                        <div class="source">
                            <div>
                                <div class="block">
                                    <div class="el-pagination">
                                        <span class="el-pagination__total">共 {{proPages.itemCount}}条</span>
                                        <button v-if="proPages.currentPage === 1" disabled="disabled" type="button" class="btn-prev">
                                            <i class="el-icon el-icon-arrow-left"></i>
                                        </button>
                                        <button v-else @click="switchPage(proPages.prevPage)" type="button" class="btn-next">
                                            <i class="el-icon el-icon-arrow-left"></i>
                                        </button>
                                        <ul class="el-pager">
                                            <li v-for="p in pages" v-if="p === proPages.currentPage" class="number active">
                                                {{p}}
                                            </li>
                                            <li v-else class="number" @click="switchPage(p)">
                                                {{p}}
                                            </li>
                                        </ul>
                                        <button v-if="proPages.currentPage === proPages.pageCount" disabled="disabled" type="button" class="btn-prev">
                                            <i class="el-icon el-icon-arrow-right"></i>
                                        </button>
                                        <button v-else @click="switchPage(proPages.nextPage)" type="button" class="btn-next">
                                            <i class="el-icon el-icon-arrow-right"></i>
                                        </button>
                                        <span class="el-pagination__jump">
                                                前往
                                                <div class="el-input el-pagination__editor is-in-pagination">
                                                    <input @keydown="changePage($event)" v-model="page" type="number" autocomplete="off" min="1" max="4" class="el-input__inner">
                                                </div>
                                                页
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="operation === 'add'" class="add">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div @click="back" class="el-page-header">
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
                            <h3 class="sku_title"><span>{{attr1}}</span> (主)</h3>
                            <div class="sku_attr">
                                <span v-for="(a,index) in attrs1" class="el-tag el-tag--dark">{{a.attr1}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr1',index)"></i></span>
                                <span @click="addAttr1Alert=true" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                            </div>
                        </div>
                        <div v-if="attr2" class="el-form-item">
                            <h3 class="sku_title"><span>{{attr2}}</span></h3>
                            <div class="sku_attr">
                                <span v-for="(a,index) in attrs2" class="el-tag el-tag--dark">{{a.attr2}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr2',index)"></i></span>
                                <span @click="addAttr2Alert=true" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                            </div>
                        </div>
                        <div v-if="attr3" class="el-form-item">
                            <h3 class="sku_title"><span>{{attr3}}</span></h3>
                            <div class="sku_attr">
                                <span v-for="(a,index) in attrs3" class="el-tag el-tag--dark">{{a.attr3}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr3',index)"></i></span>
                                <span @click="addAttr3Alert=true" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
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
                                                <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.original_price}}</div></td>
                                                <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.price}}</div></td>
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
                            <span class="el-link--inner">跳过这一步</span>
                        </a>
                    </h3>
                    <form class="el-form">
                        <div class="el-form-item">
                            <h3 id="zhao-pian-qiang" style="margin: 30px 0 10px;">商品图片信息</h3>
                            <div class="source">
                                <div>
                                    <div>
                                        <ul class="el-upload-list el-upload-list--picture-card">
                                            <li v-if="files" v-for="(file,index) in files" tabindex="0" class="el-upload-list__item is-success">
                                                <img :src="file.thumbnailUrl" alt="" class="el-upload-list__item-thumbnail">
                                                <a class="el-upload-list__item-name">
                                                    <i class="el-icon-document"></i>
                                                    {{file.originalName}}
                                                </a>
                                                <label class="el-upload-list__item-status-label">
                                                    <i class="el-icon-upload-success el-icon-check"></i>
                                                </label>
                                                <i class="el-icon-close"></i>
                                                <i class="el-icon-close-tip">按 delete 键可删除</i>
                                                <span class="el-upload-list__item-actions">
                                                        <span @click="bigImg(file.thumbnailUrl)" class="el-upload-list__item-preview">
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

        <div v-if="operation === 'edit'" class="edit">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="back" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">修改商品</div>
                        </div>
                    </div>
                </div>
                <div class="forms">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品名称</label>
                            <input v-model="proMsg.name" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请输入商品名称">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品分类</label>
                            <select v-model="proMsg.category_id" name="edit_cate" id="edit_cate" style="width: 300px; height: 40px">
                                <option v-for="cate in categorys" :value="cate.id">{{cate.name}}</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品描述</label>
                            <input v-model="proMsg.content" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请填写描述">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">保质/修期</label>
                            <select v-model.number="proMsg.lift" name="status" style="width: 300px; height: 40px">
                                <option value="">按需选择 (可不选)</option>
                                <option value="30">30天</option>
                                <option value="45">45天</option>
                                <option value="90">3个月</option>
                                <option value="180">6个月</option>
                                <option value="360">1年</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品排序</label>
                            <select v-model.number="proMsg.sort" name="sort" id="edit_sort" style="width: 300px; height: 40px">
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
                            <select v-model.number="proMsg.status" name="status" id="edit_status" style="width: 300px; height: 40px">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">宣传语句</label>
                            <textarea v-model="proMsg.propaganda" autocomplete="off" placeholder="请输入内容" maxlength="3000" class="el-textarea__inner" style="width: 300px;min-height: 70px;display:inline-block;"></textarea>
                        </div>
                        <div class="el-form-item" style="text-align: initial;">
                            <div class="source">
                                <div>
                                    <div>
                                        <ul v-if="fileKeys.length>0" class="el-upload-list el-upload-list--picture-card">
                                            <li v-for="(imgUrl,index) in fileKeys" tabindex="0" class="el-upload-list__item is-success">
                                                <img :src="imgUrl" alt="" class="el-upload-list__item-thumbnail">
                                                <i class="el-icon-close"></i>
                                                <span class="el-upload-list__item-actions">
                                                        <span @click="bigImg(imgUrl)" class="el-upload-list__item-preview">
                                                            <i class="el-icon-zoom-in"></i>
                                                        </span>
                                                        <span @click="delProImg(index)" class="el-upload-list__item-delete">
                                                            <i class="el-icon-delete"></i>
                                                        </span>
                                                    </span>
                                            </li>
                                        </ul>
                                        <label for="img" tabindex="0" class="el-upload el-upload--picture-card">
                                            <i class="el-icon-plus"></i>
                                            <input @change="uploadImg($event)" type="file" name="file" id="img" class="el-upload__input" style="display: none">
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
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <button type="button" class="el-button el-button--primary" style="width: 300px;" @click="editPro"><span>更新</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="source" style="display:inline-block;margin-bottom: 100px;">
                    <h3 style="margin: 55px 0 20px;">商品属性库存信息</h3>
                    <div v-if="attr1" class="el-form-item">
                        <h3 class="sku_title"><span>{{attr1}}</span> (主)</h3>
                        <div class="sku_attr">
                            <span v-for="(a,index) in attrs1" class="el-tag el-tag--dark">{{a.attr1}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr1',index)"></i></span>
                            <span @click="addAttr1Alert=true" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                        </div>
                    </div>
                    <div v-if="attr2" class="el-form-item">
                        <h3 class="sku_title"><span>{{attr2}}</span></h3>
                        <div class="sku_attr">
                            <span v-for="(a,index) in attrs2" class="el-tag el-tag--dark">{{a.attr2}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr2',index)"></i></span>
                            <span @click="addAttr2Alert=true" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                        </div>
                    </div>
                    <div v-if="attr3" class="el-form-item">
                        <h3 class="sku_title"><span>{{attr3}}</span></h3>
                        <div class="sku_attr">
                            <span v-for="(a,index) in attrs3" class="el-tag el-tag--dark">{{a.attr3}}<i class="el-tag__close el-icon-close" @click="delSkuAttr('attr3',index)"></i></span>
                            <span @click="addAttr3Alert=true" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                        </div>
                    </div>
                    <div>
                        <div v-if="skusList" class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 325px;">
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
                                        <th colspan="1" rowspan="1" class="is-leaf sky_item" style="width: 110px;"><div class="cell">操作</div></th>
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
                                        <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.original_price}}</div></td>
                                        <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.price}}</div></td>
                                        <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.quantity}}</div></td>
                                        <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.sort}}</div></td>
                                        <td rowspan="1" colspan="1" class="sky_item">
                                            <div v-if="sku.status === 1" class="cell">上架</div>
                                            <div v-else-if="sku.status === 2" class="cell">下架</div>
                                            <div v-else-if="sku.status === 3" class="cell">已删</div>
                                        </td>
                                        <td rowspan="1" colspan="1" class="sky_item" style="width: 110px;">
                                            <div class="cell">
                                                <button @click="skuDetail(index)" type="button" class="el-button el-button--primary is-circle">
                                                    <i class="el-icon-edit"></i>
                                                </button>
                                                <button @click="delSku(index)" type="button" class="el-button el-button--danger is-circle">
                                                    <i class="el-icon-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                        </div>
                        <div v-else class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 104px;">
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
                                        <th colspan="1" rowspan="1" class="is-leaf sky_item" style="width: 110px;"><div class="cell">操作</div></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 50px;">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: center;" colspan="7">暂无数据</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="el-form-item" style="margin-top: 50px;">
                        <div class="el-form-item__content">
                            <button @click="editPro" type="button" class="el-button el-button--primary" style="width: 300px;"><span>保存</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="operation === 'detail'" class="detail">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="back" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">商品详情</div>
                            <div class="el-page-header__content" style="margin-left: 24px;">
                                <button @click="proDetail(product_id),operation = 'edit'" type="button" class="el-button el-button--primary is-circle" style="padding: 3px;">
                                    <i class="el-icon-edit"></i>
                                </button>
                                <button @click="delPro(product_id)" type="button" class="el-button el-button--danger is-circle" style="padding: 3px;">
                                    <i class="el-icon-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="demo-block demo-zh-CN demo-table">
                    <h3 style="margin: 55px 0 20px;">商品基础信息</h3>
                    <form class="el-form demo-table-expand el-form--label-left el-form--inline ma" style="width: 20%;min-width: 300px;">
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品名称</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.name}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品分类</label>
                            <div class="el-form-item__content">
                                <span>{{cateMsg.name}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品描述</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.content}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品销量</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.sale_num}}</span>
                            </div>
                        </div>
                        <div v-if="attrList" class="el-form-item">
                            <label class="el-form-item__label">商品属性</label>
                            <div class="el-form-item__content">
                                <span v-if="attr1" class="el-tag el-tag--info el-tag--light">{{attr1}}</span>
                                <span v-if="attr2" class="el-tag el-tag--info el-tag--light">{{attr2}}</span>
                                <span v-if="attr3" class="el-tag el-tag--info el-tag--light">{{attr3}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品排序</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.sort}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品状态</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.status}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">创建时间</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.created_at}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">上次修改</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.updated_at}}</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="el-tabs__nav-scroll">
                    <div v-if="tag_sku==='sku'" class="el-tabs__item is-top" style="color:#409eff;border-bottom: 2px solid #409eff;margin-bottom: 20px;">库存信息</div>
                    <div v-else @click="tag_sku='sku'" class="el-tabs__item is-top">库存信息</div>
                    <div v-if="tag_sku==='tag'" class="el-tabs__item is-top" style="color:#409eff;border-bottom: 2px solid #409eff;margin-bottom: 20px;">标签消息</div>
                    <div v-else @click="tag_sku='tag'" class="el-tabs__item is-top">标签消息</div>
                </div>
                <div v-if="tag_sku==='sku'" style="margin-bottom:100px;">
                    <div v-if="skusList" class="source" style="display:inline-block;margin-bottom: 100px;">
                        <h3 style="margin: 55px 0 20px;font-weight: 700;">商品属性库存信息</h3>
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
                                        <tr v-for="sku in skuMsg" class="el-table__row">
                                            <td v-if="attr1" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr1}}</div></td>
                                            <td v-if="attr2" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr2}}</div></td>
                                            <td v-if="attr3" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr3}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.original_price}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.price}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.quantity}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.sort}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.status}}</div></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="source" style="display:inline-block;margin-bottom: 100px;">
                        <h3 style="margin: 55px 0 20px;font-weight: 700;">商品属性库存信息</h3>
                        <div>
                            <div class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 104px;">
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
                                <div class="el-table__body-wrapper is-scrolling-none" style="height: 50px;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                        <tbody>
                                        <tr class="el-table__row">
                                            <td style="text-align: center;" colspan="7">暂无数据</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="tag_sku==='tag'" class="tags">
                    <h3 style="margin: 55px 0 20px;text-align:center;font-weight: 700;">商品其他信息</h3>
                    <form class="el-form">
                        <div class="el-form-item">
                            <h3 style="margin: 30px 0 10px;font-size:22px;">商品图片信息</h3>
                            <div class="source">
                                <div>
                                    <div>
                                        <ul class="el-upload-list el-upload-list--picture-card">
                                            <li v-if="proMsg.imgs" v-for="img in proMsg.imgs" tabindex="0" class="el-upload-list__item is-success">
                                                <img :src="img" alt="" class="el-upload-list__item-thumbnail">
                                                <i class="el-icon-close"></i>
                                                <i class="el-icon-close-tip">按 delete 键可删除</i>
                                                <span class="el-upload-list__item-actions">
                                                        <span @click="bigImg(img)" class="el-upload-list__item-preview">
                                                            <i class="el-icon-zoom-in"></i>
                                                        </span>
                                                    </span>
                                            </li>
                                            <li v-else>
                                                <h4>没有图片信息</h4>
                                            </li>
                                        </ul>
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
                            <h3 style="margin: 30px 0 10px;font-size:22px;">商品宣传语</h3>
                            <h4>
                                <span v-if="proMsg.propaganda">{{proMsg.propaganda}}</span>
                                <span v-else>未填写</span>
                            </h4>
                        </div>
                        <div class="el-form-item">
                            <h3 style="margin: 30px 0 10px;font-size:22px;">商品保质期</h3>
                            <h4>
                                <span v-if="proMsg.lift">{{proMsg.lift}}</span>
                                <span v-else>未填写</span>
                            </h4>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--  修改弹框  -->
        <div v-if="editAlert" tabindex="-1" role="dialog" aria-modal="true" aria-label="提示" class="el-message-box__wrapper" style="z-index: 1000;">
            <div class="el-message-box">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">
                        <span>修改sku信息</span>
                    </div>
                    <button @click="editAlert=false" type="button" aria-label="Close" class="el-message-box__headerbtn">
                        <i class="el-message-box__close el-icon-close"></i>
                    </button>
                </div>
                <div v-if="attr1" class="el-message-box__content">
                    <!--<div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">{{attr1}}</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku.attr1" type="text" autocomplete="off" placeholder="" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div v-if="attr2" class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">{{attr2}}</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            &lt;!&ndash;<input v-model="sku.attr2" type="text" autocomplete="off" placeholder="" class="el-input__inner invalid">&ndash;&gt;
                            <input v-model="sku.attr2" type="text" autocomplete="off" placeholder="" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div v-if="attr3" class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">{{attr3}}</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku.attr3" type="text" autocomplete="off" placeholder="" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>-->
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">单价</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku.original_price" type="text" autocomplete="off" class="el-input__inner" placeholder="请填写单价">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">售价</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku.price" type="text" autocomplete="off" placeholder="请填写售价" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">库存</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model.number="sku.quantity" type="text" autocomplete="off" placeholder="请填写库存" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">排序</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <select v-model.number="sku.sort" name="sort" id="edit_sku_sort" class="el-input__inner">
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
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">状态</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <select v-model.number="sku.status" name="status" id="edit_sku_status" class="el-input__inner">
                                <option value="1">上架</option>
                                <option value="2">下架</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                </div>
                <div class="el-message-box__btns">
                    <button @click="editAlert=false" type="button" class="el-button el-button--default el-button--small">
                        <span>取消</span>
                    </button>
                    <button @click="editSku(sku.id)" type="button" class="el-button el-button--default el-button--small el-button--primary ">
                        <span>保存</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="editAlert" class="v-modal" tabindex="0" style="z-index: 999;"></div>
        <!--  大图遮罩层  -->
        <div v-if="bigImgList" class="v-modal" tabindex="0" style="z-index: 2051;"></div>
        <!--  添加主1属性弹框  -->
        <div v-if="addAttr1Alert" tabindex="-1" role="dialog" aria-modal="true" aria-label="提示" class="el-message-box__wrapper" style="z-index: 1000;">
            <div class="el-message-box">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">
                        <span>添加主属性信息</span>
                    </div>
                    <button @click="addAttr1Alert=false" type="button" aria-label="Close" class="el-message-box__headerbtn">
                        <i class="el-message-box__close el-icon-close"></i>
                    </button>
                </div>
                <div v-if="attr1" class="el-message-box__content">
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">{{attr1}}</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku_attrs1.attr1" type="text" autocomplete="off" placeholder="请填写属性名称" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">单价</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku_attrs1.original_price" type="text" autocomplete="off" placeholder="请输入单价" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">售价</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku_attrs1.price" type="text" autocomplete="off" placeholder="请输入售价" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">库存</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku_attrs1.quantity" type="text" autocomplete="off" placeholder="请输入库存" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">排序</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <select v-model.number="sku_attrs1.sort" name="sort" class="el-input__inner">
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
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">状态</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <select v-model.number="sku_attrs1.status" name="status" class="el-input__inner">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                </div>
                <div class="el-message-box__btns">
                    <button @click="addAttr1Alert=false" type="button" class="el-button el-button--default el-button--small">
                        <span>取消</span>
                    </button>
                    <button @click="addSkuAttr1" type="button" class="el-button el-button--default el-button--small el-button--primary ">
                        <span>保存</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="addAttr1Alert" class="v-modal" tabindex="0" style="z-index: 999;"></div>
        <!--  添加次2属性弹框  -->
        <div v-if="addAttr2Alert" tabindex="-1" role="dialog" aria-modal="true" aria-label="提示" class="el-message-box__wrapper" style="z-index: 1000;">
            <div class="el-message-box">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">
                        <span>添加次属性信息</span>
                    </div>
                    <button @click="addAttr2Alert=false" type="button" aria-label="Close" class="el-message-box__headerbtn">
                        <i class="el-message-box__close el-icon-close"></i>
                    </button>
                </div>
                <div v-if="attr2" class="el-message-box__content">
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">{{attr2}}</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku_attrs2.attr2" type="text" autocomplete="off" placeholder="请填写属性名称" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                </div>
                <div class="el-message-box__btns">
                    <button @click="addAttr2Alert=false" type="button" class="el-button el-button--default el-button--small">
                        <span>取消</span>
                    </button>
                    <button @click="addSkuAttr2" type="button" class="el-button el-button--default el-button--small el-button--primary ">
                        <span>保存</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="addAttr2Alert" class="v-modal" tabindex="0" style="z-index: 999;"></div>
        <!--  添加次3属性弹框  -->
        <div v-if="addAttr3Alert" tabindex="-1" role="dialog" aria-modal="true" aria-label="提示" class="el-message-box__wrapper" style="z-index: 1000;">
            <div class="el-message-box">
                <div class="el-message-box__header">
                    <div class="el-message-box__title">
                        <span>添加次属性信息</span>
                    </div>
                    <button @click="addAttr3Alert=false" type="button" aria-label="Close" class="el-message-box__headerbtn">
                        <i class="el-message-box__close el-icon-close"></i>
                    </button>
                </div>
                <div v-if="attr3" class="el-message-box__content">
                    <div class="el-message-box__input" style="padding: 0;">
                        <p style="width: 30%;display:inline-block;">{{attr3}}</p>
                        <div class="el-input" style="width: 50%;display:inline-block;">
                            <input v-model="sku_attrs3.attr3" type="text" autocomplete="off" placeholder="请填写属性名称" class="el-input__inner">
                        </div>
                        <div class="el-message-box__errormsg tac" style="visibility: hidden;width: 78%;">格式不正确</div>
                    </div>
                </div>
                <div class="el-message-box__btns">
                    <button @click="addAttr3Alert=false" type="button" class="el-button el-button--default el-button--small">
                        <span>取消</span>
                    </button>
                    <button @click="addSkuAttr3" type="button" class="el-button el-button--default el-button--small el-button--primary ">
                        <span>保存</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="addAttr3Alert" class="v-modal" tabindex="0" style="z-index: 999;"></div>
        <!--  删除确认弹框-->
        <Modal v-model="modal1" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>确认删除</span>
            </p>
            <div style="text-align:center">
                <p>您确定要删除该商品吗?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="del">删除</Button>
            </div>
        </Modal>
    </div>
    <!-- END MAIN -->
</template>

<script>
    import axios from 'axios'
    export default {
        name: "Product",
        data () {
            return {
                apiUrl: '',
                operation:'show',
                products:[],
                categorys:[],
                cateAttrs:[],
                attrList:false,
                tag_sku:'sku',
                skusList:false,
                proMsg:{},
                cateMsg:{},
                // 分类数据
                attr1:'',
                attr2:'',
                attr3:'',
                attrDel:[],
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
                sku_attr1:'',
                sku_attr2:'',
                sku_attr3:'',
                sku_sort:10,
                sku_status:1,
                skuMsg:[],
                skus:[],
                sku:{},
                sku_attrs1:{product_id:null,attr1:'',original_price:'',price:'',quantity:'',sort:10,status:1},
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
                editAlert:false, // 修改弹框
                modal1: false, // 确认弹框
                modal_loading: false,
                addAttr1Alert:false,
                addAttr2Alert:false,
                addAttr3Alert:false,
                pages:[], // 页
                page:1, // 当前页
                proPages:{}, // 分页信息
                tag_content:'',
                tag_lift:'',
                fileKeys:[],
                files:[],
                bigImgList:false,
                bigImgMsg:{},
            };
        },
        mounted(){
            this.getProductMsg();
            this.getCateMes();
            this.apiUrl = global.origin;
        },
        methods: {
            getProductMsg(){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/product',
                    params:{
                        page:this.page,
                    },
                    responseType:'json',
                }).then(res=>{
                    this.products = res.data.data;
                    this.proPages = res.data.page;
                    // console.log(res.data);
                    let pageCount = this.proPages.pageCount;
                    this.pages = [];
                    for (let i = 1; i <= pageCount ; i++){
                        this.pages.push(i);
                    }
                    this.$Spin.hide();
                });
            },
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
            addSkuAttr1(){
                if (!this.tell()){
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
                this.addAttr1Alert = false;
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
                    if (this.operation === 'edit') {
                        this.attrDel.push({product_id:this.product_id,attr:'attr1',value:this.attrs1[index].attr1});
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
                    if (this.operation === 'edit') {
                        this.attrDel.push({product_id:this.product_id,attr:'attr2',value:this.attrs2[index].attr2});
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
                    if (this.operation === 'edit') {
                        this.attrDel.push({product_id:this.product_id,attr:'attr3',value:this.attrs3[index].attr3});
                    }
                    this.attrs3.splice(index,1);
                }
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
                if (this.fileKeys.length>0) {
                    let image_keys = this.fileKeys.join(',');
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
            proDetail(id){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/product/detail',
                    params:{
                        id:id,
                    },
                    responseType:'json'
                }).then( res => {
                    // console.log(res.data.data);
                    this.cateDetail(res.data.data);
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
                    this.proMsg.imgs ? this.fileKeys = this.proMsg.imgs : this.fileKeys = [];
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
                        this.attrList = true;
                        this.attr1 = this.cateMsg.property.attr1;
                        this.attr2 = this.cateMsg.property.attr2 ? this.cateMsg.property.attr2 : '';
                        this.attr3 = this.cateMsg.property.attr3 ? this.cateMsg.property.attr3 : '';
                    }
                    this.steps('first');
                    this.$Spin.hide();
                    this.attrDel = [];
                });
            },
            skuDetail(index){
                this.sku = this.skuMsg[index];
                this.sku.index = index;
                this.editAlert = true;
                /*axios({
                    method:'get',
                    url:this.apiUrl+'/api/product/sku',
                    params:{
                        id:id,
                    },
                    responseType:'json'
                }).then( res=>{
                    // console.log(res);
                    this.sku = res.data.data;
                    this.editAlert = true;
                })*/
            },
            editPro(){
                this.handleSpinCustom();
                axios({
                    method:'put',
                    url:this.apiUrl+'/api/product/update',
                    params:{
                        id:this.product_id,
                        category_id:this.proMsg.category_id,
                        name:this.proMsg.name,
                        content:this.proMsg.sort,
                        sort:this.proMsg.sort,
                        status:this.proMsg.status,
                    },
                    responseType:'json',
                }).then( res => {
                    this.delAttr();
                    this.addSkus();
                });
            },
            delAttr(){
                axios({
                    method:'delete',
                    url:this.apiUrl+'/api/product/sku/attr/delete',
                    params:this.attrDel,
                    responseType:'json',
                }).then( res => {
                    this.editTags();
                })
            },
            editSku(id){
                if (!this.tellSku()){
                    return false;
                }
                this.skuMsg[this.sku.index].original_price = this.sku.original_price;
                this.skuMsg[this.sku.index].price = this.sku.price;
                this.skuMsg[this.sku.index].quantity = this.sku.quantity;
                this.skuMsg[this.sku.index].sort = this.sku.sort;
                this.skuMsg[this.sku.index].statys = this.sku.statys;
                this.editAlert = false;
                /*axios({
                    method:'put',
                    url:this.apiUrl+'/api/product/sku/update',
                    params:{
                        id:id,
                        product_id:this.proMsg.id,
                        attr1:this.attr1 ? this.sku.attr1 : null ,
                        attr2:this.attr2 ? this.sku.attr2 : null ,
                        attr3:this.attr3 ? this.sku.attr3 : null ,
                        original_price:this.sku.original_price,
                        price:this.sku.price,
                        quantity:this.sku.quantity,
                        sort:this.sku.sort,
                        status:this.sku.status,
                    },
                    responseType:'json'
                }).then( res=>{
                    // console.log(res.data);
                    this.editAlert = false;
                    if (res.data.code === -1) {
                        this.notice = res.data.msg;
                        this.error(false);
                        return false;
                    }
                    this.notice = '修改成功';
                    this.success(false);
                    this.proDetail(this.product_id)
                })*/
            },
            editTags(){
                let image_keys = '';
                if (this.fileKeys !== null){
                    image_keys = this.fileKeys.join(',');
                }
                axios({
                    method:"put",
                    url:this.apiUrl+'/api/product/tag/update',
                    params:{
                        product_id:this.product_id,
                        tag_id:1,
                        value:image_keys,
                    },
                    responseType:'json'
                }).then( res=> {
                    // console.log(res.data);
                });
                axios({
                    method:"put",
                    url:this.apiUrl+'/api/product/tag/update',
                    params:{
                        product_id:this.product_id,
                        tag_id:2,
                        value:this.proMsg.propaganda
                    },
                    responseType:'json'
                }).then( res=> {
                    // console.log(res.data);
                });
                axios({
                    method:"put",
                    url:this.apiUrl+'/api/product/tag/update',
                    params:{
                        product_id:this.product_id,
                        tag_id:3,
                        value:this.proMsg.lift
                    },
                    responseType:'json'
                }).then( res=> {
                    // console.log(res.data);
                });
                this.notice = '修改成功';
                this.success(false);
                this.proDetail(this.product_id);
                this.$Spin.hide();
            },
            delPro(){
                this.enterAlert = false;
                axios({
                    method:'delete',
                    url:this.apiUrl+'/api/product/delete',
                    params:{
                        id:this.product_id,
                    },
                    responseType:'json'
                }).then( res => {
                    this.modal_loading = false;
                    this.modal1 = false;
                    this.notice = res.data.msg;
                    if (res.data.code === 0){
                        this.success(false);
                    } else {
                        this.error(false);
                    }
                    this.getProductMsg();
                })
            },
            delSku(index){
                if (this.skuMsg[index].status === 3) {
                    this.notice = '已经删除';
                    this.info(false);
                    return true;
                }
                this.skuMsg[index].status = 3;
                this.notice = '删除成功';
                this.success(false);
                /*axios({
                    method:'delete',
                    url:this.apiUrl+'/api/product/sku/delete',
                    params:{
                        id:id,
                    },
                    responseType:'json'
                }).then( res => {
                    this.notice = res.data.msg;
                    this.info(false);
                    if (res.data.data === 0 ){
                        this.proDetail(this.product_id);
                    }
                })*/
            },
            back(){
                location. reload();
                /*this.operation='show';
                this.name = '';
                this.attr = '';
                this.attr1 = '';
                this.attr2 = '';
                this.attr3 = '';
                this.attrList = false;*/
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
            switchPage(page){
                this.page = page;
                this.getProductMsg();
            },
            changePage(ev){
                let keynum = ev.keyCode;
                let keychar = String.fromCharCode(keynum);
                // console.log(keynum,keychar);
                // 回车13
                if (keynum === 13){
                    this.page > this.proPages.pageCount ? this.page = this.proPages.pageCount : null ;
                    this.page < 1 ? this.page = 1 : null ;
                    this.getProductMsg();
                }
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
                    this.fileKeys.push(res.data.data.thumbnailUrl);
                    this.files.push(res.data.data);
                    // console.log(res.data);
                })
            },
            delImg(index){
                this.files.splice(index,1);
                this.fileKeys.splice(index,1);
            },
            delProImg(index){
                this.fileKeys.splice(index,1);
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
            del(){
                this.modal_loading = true;
                this.delPro();
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
        },
    }
</script>

<style scoped>
    select{
        padding-left: 15px !important;
    }
    .shows{
        margin-top: 20px;
    }
    .add, .edit, .detail{
        padding: 20px;
        text-align: center;
    }
    .detail{
        padding: 20px;
    }
    .add .container, .edit .container, .detail .container{
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
