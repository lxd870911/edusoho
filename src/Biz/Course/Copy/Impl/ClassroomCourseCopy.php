<?php

namespace Biz\Course\Copy\Impl;

use Biz\Course\Dao\CourseSetDao;
use Biz\Course\Service\CourseService;
use Biz\Classroom\Service\ClassroomService;
use Biz\Taxonomy\Dao\TagOwnerDao;

class ClassroomCourseCopy extends CourseCopy
{
    /**
     * 复制链说明：
     * CourseSet 课程信息
     * - Course 教学计划及相关信息
     * - Testpaper (课程下创建的Testpaper)
     * - Material （课程下上传的Material）.
     *
     *
     * @param $biz
     */
    public function __construct($biz)
    {
        parent::__construct($biz);
    }

    /*
     * $source = $originalCourseSet
     * $config : courseId (course to copy), classroomId
     */
    protected function copyEntity($source, $config = array())
    {
        $newCourseSet = $this->doCopyCourseSet($source, $config);
        $this->doCopyTagOwners($newCourseSet);
        
        $course = $this->getCourseDao()->get($config['courseId']);

        $user = $this->biz['user'];
        $courseSetId = $newCourseSet['id'];

        $newCourse = $this->doCopy($course);

        $newCourse = $this->extendConfigFromClassroom($newCourse, $config['classroomId']);
        $newCourse['isDefault'] = $course['isDefault'];
        $modeChange = false;
        $newCourse['parentId'] = $course['id'];
        $newCourse['locked'] = 1; //默认锁定
        $newCourse['courseSetId'] = $courseSetId;
        $newCourse['creator'] = $user['id'];
        $newCourse['status'] = 'published';
        $newCourse['teacherIds'] = array($user['id']);

        $newCourse = $this->getCourseDao()->create($newCourse);

        $this->getCourseSetDao()->update($newCourseSet['id'], array('defaultCourseId' => $newCourse['id']));

        $this->childrenCopy($course, array(
            'newCourse' => $newCourse,
            'newCourseSet' => $newCourseSet,
            'classroomId' => $config['classroomId'],
            'modeChange' => $modeChange,
            'isCopy' => true, // 用于标记是复制还是clone，clone不需要记录parentId
        ));

        return $newCourse;
    }

    private function extendConfigFromClassroom($newCourse, $classroomId)
    {
        $classroom = $this->getClassroomService()->getClassroom($classroomId);
        $expiryData = $this->getCourseService()->buildCourseExpiryDataFromClassroom(
            $classroom['expiryMode'],
            $classroom['expiryValue']
        );

        $newCourse = array_replace($newCourse, $expiryData);
        $newCourse['vipLevelId'] = $classroom['vipLevelId'];

        return $newCourse;
    }

    private function doCopyCourseSet($source, $config)
    {
        $courseSetCopy = new CourseSetCopy($this->biz);

        return $courseSetCopy->copy($source, $config);
    }

    public function doCopyTagOwners($newCourseSet)
    {
        if (empty($newCourseSet['tags'])) {
            return false;
        }
        foreach ($newCourseSet['tags'] as $tag) {
            $tagOwner = array(
                'ownerType' => 'course-set',
                'ownerId' => $newCourseSet['id'],
                'tagId' => $tag,
                'userId' => $newCourseSet['creator'],
            );
            $this->getTagOwnerDao()->create($tagOwner);
        }

        return true;
    }

    /**
     * @return CourseSetDao
     */
    private function getCourseSetDao()
    {
        return $this->biz->dao('Course:CourseSetDao');
    }

    /**
     * @return TagOwnerDao
     */
    private function getTagOwnerDao()
    {
        return $this->biz->dao('Taxonomy:TagOwnerDao');
    }

    /**
     * @return CourseService
     */
    private function getCourseService()
    {
        return $this->biz->service('Course:CourseService');
    }

    /**
     * @return ClassroomService
     */
    private function getClassroomService()
    {
        return $this->biz->service('Classroom:ClassroomService');
    }
}
