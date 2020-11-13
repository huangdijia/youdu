<?php

declare(strict_types=1);
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu\Exceptions;

class DeptErrCode
{
    const ERRCODE_ACCOUNT_NOTEXIST = 300001; // UserId不存在

    const ERRCODE_ACCOUNT_AUTHFAILED = 300002; // 帐号验证失败

    const ERRCODE_DEPT_ROOT_FORBIDDEN = 300101; // 不能操作根部门

    const ERRCODE_INVALID_FORMAT_DEPTID = 300102; // 无效的部门ID格式(int)

    const ERRCODE_INVALID_FORMAT_DEPTNAME = 300103; // 无效的部门名格式(string)

    const ERRCODE_INVALID_FORMAT_DEPTSORTID = 300104; // 无效的部门排序ID格式(int)

    const ERRCODE_INVALID_FORMAT_DEPTPARENTID = 300105; // 无效的部门父ID格式(string)

    const ERRCODE_INVALID_DEPTID = 300106; // 无效的部门ID

    const ERRCODE_INVALID_DEPTNAME = 300107; // 无效的部门名

    const ERRCODE_INVALID_DEPTPARENTID = 300108; // 无效的部门父ID

    const ERRCODE_MISS_DEPTID = 300109; // 缺少部门ID

    const ERRCODE_MISS_DEPTNAME = 300110; // 缺少部门名

    const ERRCODE_MISS_DEPTPARENTID = 300111; // 缺少部门父ID

    const ERRCODE_EXIST_DEPT = 300112; // 部门ID已存在

    const ERRCODE_EXIST_DEPT_SORTID = 300113; // 部门排序ID已存在

    const ERRCODE_DEPT_NOT_EXIST = 300114; // 部门不存在

    const ERRCODE_DEPT_HAS_SUBDEPT = 300115; // 部门下存在子部门

    const ERRCODE_DEPT_HAS_USERS = 300116; // 部门下存在用户

    const ERRCODE_OVERLIMIT_DEPTNAME = 300117; // 部门名过长

    const ERRCODE_NOTEXIST_ORG = 300118; // 组织架构不存在

    const ERRCODE_INVALID_DEPTALIAS = 300119; // 无效的部门索引(alias)

    const ERRCODE_MISS_USERID = 300201; // 缺少用户ID

    const ERRCODE_MISS_USERNAME = 300202; // 缺少用户名

    const ERRCODE_MISS_USERDEPT = 300203; // 用户没有指定部门

    const ERRCODE_MISS_USERLIST = 300204; // 缺少用户列表

    const ERRCODE_INVALID_FORMAT_USERID = 300205; // 无效的userId格式

    const ERRCODE_INVALID_FORMAT_USERNAME = 300206; // 无效的用户名称格式

    const ERRCODE_INVALID_FORMAT_USERGENDER = 300207; // 无效的gender格式

    const ERRCODE_INVALID_FORMAT_USEREMAIL = 300208; // 无效的email格式

    const ERRCODE_INVALID_FORMAT_USERPHONE = 300209; // 无效的phone格式

    const ERRCODE_INVALID_FORMAT_USERMOBILE = 300210; // 无效的mobile格式

    const ERRCODE_INVALID_FORMAT_USERDEPT = 300211; // 无效的用户部门格式

    const ERRCODE_INVALID_FORMAT_USERLIST = 300212; // 无效的用户列表格式

    const ERRCODE_INVALID_FORMAT_PASSWORD = 300213; // 无效的password格式

    const ERRCODE_INVALID_FORMAT_AUTHTYPE = 300214; // 无效的认证类型

    const ERRCODE_INVALID_FORMAT_POSITION = 300215; // 无效的职务格式

    const ERRCODE_INVALID_FORMAT_WEIGHT = 300216; // 无效的职务权重格式

    const ERRCODE_INVALID_FORMAT_SORTID = 300217; // 无效的排序格式

    const ERRCODE_OVERLIMIT_USERID = 300218; // userId超过长度

    const ERRCODE_OVERLIMIT_USERNAME = 300219; // user名称超过长度

    const ERRCODE_OVERLIMIT_USEREMAIL = 300220; // email超过长度

    const ERRCODE_OVERLIMIT_USERDEPT = 300221; // 用户部门超过长度

    const ERRCODE_OVERLIMIT_USERLIST = 300222; // userList超过长度

    const ERRCODE_INVALID_USERID = 300223; // 无效的userId

    const ERRCODE_USER_EXIST = 300224; // 用户已存在

    const ERRCODE_USER_NOTEXIST = 300225; // 用户不存在

    const ERRCODE_EMPTY_DEPT = 300226; // 空的部门

    const ERRCODE_USER_NOTIN_DEPT = 300227; // 用户不属于该部门

    const ERRCODE_INVALID_FORMAT_DEPTLIST = 300301; // 无效的部门列表格式

    const ERRCODE_INVALID_FORMAT_DEPT = 300302; // 无效的部门格式

    const ERRCODE_INVALID_FORMAT_USER = 300303; // 无效的用户格式

    const ERRCODE_INVALID_FORMAT_POSITIONS = 300304; // 无效的部门职务信息格式

    const ERRCODE_MISS_GENDER = 300306; // 缺少性别

    const ERRCODE_NOTEXIST_DEPT = 300307; // 部门不存在

    const ERRCODE_NOTEXIST_PARENTDEPT = 300308; // 父部门不存在

    const ERRCODE_REPEAT_USERID = 300311; // 重复的userId

    const ERRCODE_NOTEXIST_JOBID = 300311; // jobId不存在

    const ERRCODE_EXIST_ENT_REPLACEALL = 300312; // 已存在同步请求
}
