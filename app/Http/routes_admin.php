<?php
Route::get('/', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
Route::get('/auth_url', ['as' => 'admin.auth_url', 'uses' => 'Admin\AdminController@index']);
Route::post('/checklogin', ['as' => 'auth.checklogin', 'uses' => 'Auth\AuthController@checkLogin']);
Route::get('/home', ['as' => 'logout', 'uses' => 'Admin\AdminController@home']);

//Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
Route::group(['namespace' => 'Admin'], function () {
    //退出登录
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AdminController@logout']);
    //后台首页
    Route::get('/index', ['as' => 'admin.hhs', 'uses' => 'AdminController@index']);
    //用户管理列表
    Route::get('/user', ['as' => 'admin.user', 'uses' => 'UserController@index']);
    //添加用户界面
    Route::get('/usercreate', ['as' => 'admin.usercreate', 'uses' => 'UserController@userCreatePage']);
    //添加用户
    Route::post('/saveuser', ['as' => 'admin.saveuser', 'uses' => 'UserController@saveUser']);
    //编辑用户界面
    Route::get('/usereditcreate/{uid}', ['as' => 'admin.usereditcreate', 'uses' => 'UserController@userEditCreate']);
    //重置密码
    Route::post('/resetpwd', ['as' => 'admin.resetpwd', 'uses' => 'UserController@resetPwd']);
    //用户详细信息
    Route::get('/userinfo/{uid}', ['as' => 'admin.userinfo', 'uses' => 'UserController@userInfo']);
    //编辑菜单
    Route::post('/edituser', ['as' => 'admin.edituser', 'uses' => 'UserController@editUser']);
    //用户列表
    Route::get('/getuser', ['as' => 'admin.getuser', 'uses' => 'UserController@userList']);
    //用户添加角色页面
    Route::get('/userfunc/{uid}', ['as' => 'admin.userfunc', 'uses' => 'UserController@userFunc']);
    //启用或禁用用户
    Route::post('/updatestatus', ['as' => 'admin.updatestatus', 'uses' => 'UserController@updateUserStatus']);
    //给用户添加角色
    Route::post('/saveuserroles', ['as' => 'admin.saveuserroles', 'uses' => 'UserController@saveUserRoles']);
    //菜单管理列表
    Route::get('/menu', ['as' => 'admin.menu', 'uses' => 'MenuController@index']);
    //菜单列表
    Route::get('/getmenus', ['as' => 'admin.getmenus', 'uses' => 'MenuController@menuList']);
    //添加菜单界面
    Route::get('/menucreate', ['as' => 'admin.menucreate', 'uses' => 'MenuController@menuCreatePage']);
    //更新菜单状态
    Route::post('/menustatus', ['as' => 'admin.menustatus', 'uses' => 'MenuController@updateMenuStatus']);
    //保存菜单
    Route::post('/savemenu', ['as' => 'admin.savemenu', 'uses' => 'MenuController@saveMenu']);
    //跳转到编辑菜单页面
    Route::get('/menueditcreate/{mid}', ['as' => 'admin.menueditcreate', 'uses' => 'MenuController@menuEditCreate']);
    //编辑菜单
    Route::post('/editmenu', ['as' => 'admin.editmenu', 'uses' => 'MenuController@editMenu']);
    //删除菜单
    Route::post('/delmenu', ['as' => 'admin.delmenu', 'uses' => 'MenuController@menuDel']);
    //角色列表
    Route::get('/role', ['as' => 'admin.role', 'uses' => 'RoleController@index']);
    //更新角色状态
    Route::post('/rolestatus', ['as' => 'admin.rolestatus', 'uses' => 'RoleController@updateroleStatus']);
    //删除角色
    Route::post('/delrole', ['as' => 'admin.delrole', 'uses' => 'RoleController@roleDel']);
    //角色列表
    Route::get('/getroles', ['as' => 'admin.getroles', 'uses' => 'RoleController@roleList']);
    //添加角色界面
    Route::get('/rolecreate', ['as' => 'admin.rolecreate', 'uses' => 'RoleController@roleCreatePage']);
    //保存角色
    Route::post('/saverole', ['as' => 'admin.saverole', 'uses' => 'RoleController@saveRole']);
    //编辑角色页面
    Route::get('/roleeditcreate/{rid}', ['as' => 'admin.roleeditcreate', 'uses' => 'RoleController@roleEditCreate']);
    //编辑角色保存
    Route::post('/editrole', ['as' => 'admin.editrole', 'uses' => 'RoleController@editRole']);
    //角色权限
    Route::get('/rolefunc/{rid}', ['as' => 'admin.rolefunc', 'uses' => 'RoleController@roleFunc']);
    //保存角色权限关联
    Route::post('/savemenus', ['as' => 'admin.savemenus', 'uses' => 'RoleController@saveRoleMenus']);
});
Route::group(['namespace' => 'Tongbu'], function () {
    Route::get('/dash', ['as' => 'dash', 'uses' => 'TongBuController@dash']);
    Route::get('/tongbu', ['as' => 'tongbu', 'uses' => 'TongBuController@index']);
    Route::get('/tb', ['as' => 'tb', 'uses' => 'TongBuController@home']);
    Route::get('/tbcount', ['as' => 'tb', 'uses' => 'TongBuController@tbcount']);
    //更新橱窗产品
    Route::get('/chuchuang', ['as' => 'tongbu.chuchuang', 'uses' => 'TongBuController@updateChuChuang']);
    //商品管理列表
    Route::get('/product', ['as' => 'tongbu.product', 'uses' => 'ProductController@index']);
    //获取商品列表
    Route::get('/getproduct', ['as' => 'tongbu.getproduct', 'uses' => 'ProductController@productList']);
    //今日操作
    Route::get('/today', ['as' => 'tongbu.today', 'uses' => 'ProductController@today']);
    //今日操作列表
    Route::get('/todayproduct', ['as' => 'tongbu.todayproduct', 'uses' => 'ProductController@todayProduct']);
    //更新单个商品
    Route::get('/updateProduct', ['as' => 'tongbu.updateProduct', 'uses' => 'TongBuController@updateProduct']);

    // Route::get('/login', ['as' => 'tongbu.login', 'uses' => 'TongBuController@login']);
    //获取类目信息
    Route::get('/categoryInfo/{cid}', ['as' => 'tongbu.categoryInfo', 'uses' => 'TongBuController@categoryInfo']);
    //产品搜索
    Route::get('/search', ['as' => 'product.search', 'uses' => 'ProductController@search']);
    //产品搜索__今日操作搜索
    Route::get('/search_today', ['as' => 'product.search_today', 'uses' => 'ProductController@searchToday']);
    //复制发布1
    Route::get('/fabu_count/{productId}', ['as' => 'fabu.fabu_count', 'uses' => 'FabuController@index']);
    Route::get('/fabu_detail', ['as' => 'fabu.fabu_detail', 'uses' => 'FabuController@fabuDetail']);
    //获取标题关键词
    Route::get('/getkeylist/{fid}', ['as' => 'fabu.getkeylist', 'uses' => 'FabuController@getFkeys']);
    //保存标题词语
    Route::post('/saveKeys', ['as' => 'fabu.saveKeys', 'uses' => 'FabuController@saveKeys']);
    //更新标题词语
    Route::post('/editKey', ['as' => 'fabu.editKey', 'uses' => 'FabuController@editKey']);
    //删除标题词语
    Route::post('/delKey', ['as' => 'fabu.delKey', 'uses' => 'FabuController@delKey']);
    //获取标题生成格式
    Route::get('/gettitleformat', ['as' => 'fabu.gettitleformat', 'uses' => 'FabuController@getTitleFormat']);
    //获取关键词
    Route::get('/getKeys/{status}', ['as' => 'fabu.getKeys', 'uses' => 'FabuController@getKeys']);
    //获取复制产品信息列表
    Route::get('/gettempList', ['as' => 'fabu.gettempList', 'uses' => 'FabuController@getTempProductList']);
    //保存临时关键词
    Route::post('/savetempkey', ['as' => 'fabu.savetempkey', 'uses' => 'FabuController@saveTempKeys']);
    //删除临时关键词
    Route::post('/deltempkey', ['as' => 'fabu.deltempkey', 'uses' => 'FabuController@delTempKey']);
    //关键词高级设置页面
    Route::get('/keyseting', ['as' => 'fabu.keyseting', 'uses' => 'FabuController@advancedSeting']);
    //关键词高级设置信息
    Route::get('/keysetinginfo', ['as' => 'fabu.keysetinginfo', 'uses' => 'FabuController@advancedSetingInfo']);
    //关键词高级设置保持
    Route::post('/advancedset', ['as' => 'fabu.advancedset', 'uses' => 'FabuController@advancedSet']);
    //自动生成关键词
    Route::get('/keygenerate/{cateid}', ['as' => 'fabu.keygenerate', 'uses' => 'FabuController@keyGenerate']);
    //自动生成标题
    Route::get('/titlegenerate/{type}', ['as' => 'fabu.keygenerate', 'uses' => 'FabuController@titleGenerate']);
    //图片上传
    Route::post('/uploadimage', ['as' => 'upload.uploadimage', 'uses' => 'UploadController@uploadImage']);
    //图片上传
    Route::post('/uploadimage1', ['as' => 'upload.uploadimage1', 'uses' => 'UploadController@uploadImage1']);
    //图片列表
    Route::get('/getimagelist/{page}/{gid}', ['as' => 'upload.getimagelist', 'uses' => 'UploadController@getImageList']);
    //图片相册列表
    Route::get('/getimagegroup', ['as' => 'upload.getimagegroup', 'uses' => 'UploadController@getImageGroup']);
    //图片银行
    Route::get('/imagebank', ['as' => 'fabu.imagebank', 'uses' => 'FabuController@imageBank']);
    //批量替换产品图片
    Route::post('/setimgs', ['as' => 'fabu.setProductImages', 'uses' => 'UploadController@setProductImages']);
    //批量删除产品图片
    Route::get('/deleteimages/{count}/{type}', ['as' => 'fabu.imagebank', 'uses' => 'UploadController@deleteImages']);
    //产品发布
    Route::get('/fabu', ['as' => 'fabu.fabu', 'uses' => 'FabuController@fabu']);
    //产品发布_单个产品
    Route::get('/fabu_one', ['as' => 'fabu.fabu_one', 'uses' => 'FabuController@fabu_one']);
    //复制产品数量
    Route::get('/fuzhi/{productid}/{count}', ['as' => 'fabu.fuzhi', 'uses' => 'FabuController@fuZhi']);
    //获取单个复制产品信息
    Route::get('/getproductinfo/{productid}', ['as' => 'fabu.getproductinfo', 'uses' => 'FabuController@getProductInfo']);
    //批量更新复制产品的详情信息
    Route::post('/updatedesc', ['as' => 'fabu.updatedesc', 'uses' => 'FabuController@updateDesc']);
    Route::get('/test', ['as' => 'fabu.test', 'uses' => 'FabuController@test']);
    //图片银行
    Route::get('/photo_index', ['as' => 'photo.photo_index', 'uses' => 'PhotoController@index']);
    //图片银行图片上传
    Route::post('/photoupload', ['as' => 'photo.photoupload', 'uses' => 'PhotoController@photoUpload']);
    //图片银行图片删除
    Route::post('/deleteimage', ['as' => 'photo.deleteImage', 'uses' => 'UploadController@deleteImage']);
    //获取产品分组信息
    Route::get('/getgroup/{groupid}', ['as' => 'group.getgroup', 'uses' => 'GroupController@getGroupById']);
    Route::get('/getgroup1/{groupid}', ['as' => 'group.getgroup', 'uses' => 'GroupController@getGroupById1']);
    //获取分组列表
    Route::get('/getgrouplist', ['as' => 'group.getgrouplist', 'uses' => 'GroupController@getGroupList']);
    //复制产品详情
    Route::get('/todetail/{productid}', ['as' => 'fabu.todetail', 'uses' => 'FabuController@toDetail']);
    //复制产品参数
    Route::get('/toparam', ['as' => 'fabu.toparam', 'uses' => 'FabuController@toParam']);
    //复制产品关键词
    Route::get('/tokey', ['as' => 'fabu.tokey', 'uses' => 'FabuController@toKey']);
    //复制产品标题
    Route::get('/totitle', ['as' => 'fabu.totitle', 'uses' => 'FabuController@toTitle']);
    //复制产品物流信息
    Route::get('/towuliu', ['as' => 'fabu.towuliu', 'uses' => 'FabuController@toWuliu']);
    //复制产品关键词
    Route::get('/tobatch', ['as' => 'fabu.toBatch', 'uses' => 'FabuController@toBatch']);
    //复制产品获取运费模板列表
    Route::get('/yfmblist', ['as' => 'fabu.yfmblist', 'uses' => 'FabuController@yunFei']);
    /****************************************批量编辑***********************************************/
    //批量编辑首页
    Route::post('/batch', ['as' => 'batch.batch', 'uses' => 'BatchController@index']);
    //批量编辑_标题编辑
    Route::get('/batchtitle', ['as' => 'batch.batchtitle', 'uses' => 'BatchController@batchTitle']);
    //批量编辑_关键词编辑
    Route::get('/batchkey', ['as' => 'batch.batchkey', 'uses' => 'BatchController@batchKey']);
    //获取批量编辑产品列表
    Route::get('/getbatchList', ['as' => 'batch.getbatchList', 'uses' => 'BatchController@getBatchProductList']);
    //批量编辑_标题编辑
    Route::post('/titlereplace', ['as' => 'batch.titlereplace', 'uses' => 'BatchController@titleReplace']);
    //批量编辑产品发布
    Route::get('/batchfabu', ['as' => 'batch.batchfabu', 'uses' => 'BatchController@batchFabu']);
    //获取单个产品信息
    Route::get('/getproductinfo1/{productId}', ['as' => 'batch.getproductinfo', 'uses' => 'BatchController@getProductInfo']);
    //编辑类目
    Route::get('/batchcategory', ['as' => 'batch.batchcategory', 'uses' => 'BatchController@batchcategory']);
    //批量编辑_类目编辑
    Route::get('/batchimg', ['as' => 'batch.batchimg', 'uses' => 'BatchController@batchImg']);
    //批量编辑_获取待编辑产品图片
    Route::get('/batchimglist', ['as' => 'batch.batchimglist', 'uses' => 'BatchController@getBatchImgList']);
    //批量编辑__编辑图片_选择图片
    Route::post('/checkimage', ['as' => 'batch.checkimage', 'uses' => 'BatchController@checkImage']);
    //批量编辑__编辑图片_删除图片
    Route::get('/delimg/{count}/{type}', ['as' => 'fabu.delimg', 'uses' => 'BatchController@delImages']);
    //批量编辑__编辑产品价格
    Route::get('/batchprice', ['as' => 'fabu.batchprice', 'uses' => 'BatchController@batchPrice']);
    //批量编辑_获取待编辑产价格信息
    Route::get('/getbatchpricelist', ['as' => 'batch.getbatchpricelist', 'uses' => 'BatchController@getBatchPriceList']);
    //批量编辑__编辑产品详情页面
    Route::get('/batchdetail', ['as' => 'batch.batchdetail', 'uses' => 'BatchController@batchDetail']);
    //批量编辑__获取产品列表编辑详情使用
    Route::get('/getbatchdetaillist', ['as' => 'batch.getbatchdetaillist', 'uses' => 'BatchController@getBatchDetailList']);
    //批量编辑__获取产品列表编辑详情使用
    Route::post('/batchdetaisave', ['as' => 'batch.batchdetaisave', 'uses' => 'BatchController@batchDetailSave']);
    //批量编辑__获取产品最小起订量
    Route::get('/batchminorder', ['as' => 'batch.batchminorder', 'uses' => 'BatchController@batchMinOrder']);
    //批量编辑__最小起订量保存
    Route::post('/batchminordersave', ['as' => 'batch.batchminordersave', 'uses' => 'BatchController@batchMinOrderSave']);
    //批量编辑__编辑产品详情图片
    Route::get('/batchdetailimg', ['as' => 'batch.batchdetailimg', 'uses' => 'BatchController@batchDetailImg']);
    //批量编辑__编辑产品详情图片
    Route::get('/getbatchdetailimglist', ['as' => 'batch.getbatchdetailimglist', 'uses' => 'BatchController@getBatchDetailImgList']);
    //批量编辑__根据ID获取待编辑产品列表
    Route::get('/getproductbactbyids', ['as' => 'batch.getproductbactbyids', 'uses' => 'BatchController@getProductBactListByIds']);
    //批量编辑__图片银行
    Route::get('/batchimgbank', ['as' => 'batch.batchimgbank', 'uses' => 'BatchController@batchImgBank']);
    //批量编辑__图片银行
    Route::get('/batchimgbank1', ['as' => 'batch.batchimgbank', 'uses' => 'BatchController@batchImgBank1']);
    //批量编辑__替换产品详情里面的图片
    Route::get('/replacedetailimg', ['as' => 'batch.replacedetailimg', 'uses' => 'BatchController@replaceDetailImg']);
    //批量编辑__删除产品详情里面的图片
    Route::get('/removedetailimg', ['as' => 'batch.removedetailimg', 'uses' => 'BatchController@removeDetailImg']);
    //批量编辑__指定图片前插入图片
    Route::post('/insertimg', ['as' => 'batch.insertimg', 'uses' => 'BatchController@insertImg']);
    //批量编辑__删除插入产品详情里面的图片
    Route::get('/removeinsertdetailimg', ['as' => 'batch.removeinsertdetailimg', 'uses' => 'BatchController@removeInsertDetailImg']);
    //批量编辑__编辑计量单位页面
    Route::get('/batchunit', ['as' => 'batch.batchunit', 'uses' => 'BatchController@batchUnit']);
    //批量编辑__获取计量单位
    Route::get('/getunitlist', ['as' => 'batch.getunitlist', 'uses' => 'BatchController@getUnitList']);
    //批量编辑__获取批量编辑计量单位产品列表
    Route::get('/getbatchunitList', ['as' => 'batch.getbatchunitList', 'uses' => 'BatchController@getBatchUnitlList']);
    //批量编辑__保存产品计量单位
    Route::post('/saveunit', ['as' => 'batch.saveunit', 'uses' => 'BatchController@saveUnit']);
    //批量编辑__编辑产品价格区间页面
    Route::get('/batchpricerange', ['as' => 'batch.batchpricerange', 'uses' => 'BatchController@batchPriceRange']);
    //批量编辑__保存产品价格区间
    Route::post('/savebatchpricerange', ['as' => 'batch.savebatchpricerange', 'uses' => 'BatchController@saveBatchPriceRange']);
    //批量编辑__保存产品FOB价格
    Route::post('/savebatchfobprice', ['as' => 'batch.saveBatchFobPrice', 'uses' => 'BatchController@saveBatchFobPrice']);
    //批量编辑__获取国家列表
    Route::get('/getcountrylist', ['as' => 'batch.getcountrylist', 'uses' => 'BatchController@getCountryList']);
    //批量编辑__保存产品原产地
    Route::post('/savechandi', ['as' => 'batch.savechandi', 'uses' => 'BatchController@saveChandi']);
    //批量编辑__保存产品品牌
    Route::post('/savepinpai', ['as' => 'batch.savepinpai', 'uses' => 'BatchController@savePinPai']);
    //批量编辑__保存产品型号
    Route::post('/savexinghao', ['as' => 'batch.savexinghao', 'uses' => 'BatchController@saveXinghao']);
    //批量编辑__获取产品信息，编辑产品类目：产地、型号、品牌
    Route::get('/getbatchcatetorylist', ['as' => 'batch.getbatchcatetorylist', 'uses' => 'BatchController@getBatchCatetoryList']);
    //批量编辑__自定义属性页面
    Route::post('/batchcustomcategory', ['as' => 'batch.batchcustomcategory', 'uses' => 'BatchController@saveBatchCustomCate']);
    //批量编辑__获取类目
    Route::get('/getcategorylist/{cateid}', ['as' => 'batch.getCategoryList', 'uses' => 'BatchController@getCategoryList']);
    //批量编辑__保存类目属性
    Route::post('/savecategory', ['as' => 'batch.savecategory', 'uses' => 'BatchController@saveCategory']);
    //搜索排行
    Route::get('/searchrank', ['as' => 'search.searchrank', 'uses' => 'SearchController@searchRank']);
    //搜索
    Route::get('/searchkey/{key}', ['as' => 'search.searchkey', 'uses' => 'SearchController@searchKey']);
    //批量编辑__导入型号
    Route::post('/savefilexinghao', ['as' => 'batch.savefilexinghao', 'uses' => 'BatchController@saveFileXinghao']);
    //批量替换产品图片
    Route::post('/savebatchproductimages', ['as' => 'batch.savebatchproductimages', 'uses' => 'BatchController@saveBatchProductImages']);
    //批量编辑__查找替换产品详情中内容
    Route::post('/editbatchproductdetail', ['as' => 'batch.editbatchproductdetail', 'uses' => 'BatchController@editBatchProductDetail']);
    //测试
    Route::get('/gettp', ['as' => 'tb.gettp', 'uses' => 'TongBuController@getp']);
    //草稿箱__首页
    Route::get('/box', ['as' => 'box.box', 'uses' => 'BoxController@index']);
    //草稿箱__产品列表
    Route::get('/draftboxlist', ['as' => 'box.draftboxlist', 'uses' => 'BoxController@draftBoxList']);
    Route::get('/fabubox', ['as' => 'box.fabubox', 'uses' => 'BoxController@fabuBox']);
    Route::get('/editbox', ['as' => 'box.editbox', 'uses' => 'BoxController@editBox']);
    Route::get('/searchbox', ['as' => 'box.searchbox', 'uses' => 'BoxController@searchBox']);
    Route::get('/boxeditindex', ['as' => 'batch.boxeditindex', 'uses' => 'BatchController@edit_index']);
    //删除草稿箱发布产品
    Route::get('/removefabu/{productid}', ['as' => 'box.removefabu', 'uses' => 'FabuController@removeFabu']);
    //删除草稿箱待编辑发布产品
    Route::get('/removeeditfabu/{productid}', ['as' => 'box.removeeditfabu', 'uses' => 'BoxController@removeEditFabu']);
    //产品存入草稿箱
    Route::get('/putdraftbox', ['as' => 'box.putdraftbox', 'uses' => 'BoxController@putDraftBox']);
    //更新复制发布产品的标题
    Route::post('/savetitle', ['as' => 'fabu.savetitle', 'uses' => 'FabuController@saveTitle']);
    //打乱图片顺序
    Route::get('/randimage', ['as' => 'fabu.randimage', 'uses' => 'FabuController@randImage']);
    //删除产品
    Route::get('/deleteproduct', ['as' => 'pro.deleteproduct', 'uses' => 'ProductController@deleteProduct']);
});
