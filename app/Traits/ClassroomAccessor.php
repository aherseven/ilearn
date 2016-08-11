<?php

namespace App\Traits;

trait ClassroomAccessor 
{
	public function getPaginateDiscussionsAttribute()
	{
		return $this->discussions()->where('parent_id', '')->paginate(7);
	}

	public function getCountAvailableAssignmentsAttribute()
	{
		return $this->assignments()
			->where('start', '<', date('Y-m-d H:i:s'))
			->where('deadline', '>', date('Y-m-d H:i:s'))
			->count();
	}

	public function getPaginateAvailableAssignmentsAttribute()
	{
		return $this->assignments()
			->where('start', '<', date('Y-m-d H:i:s'))
			->where('deadline', '>', date('Y-m-d H:i:s'))
			->paginate(7, ['*'], 'class_assignment');
	}

	public function getShowFiveAssignmentsAttribute()
	{
		return $this->assignments()
			->where('start', '<', date('Y-m-d H:i:s'))
			->where('deadline', '>', date('Y-m-d H:i:s'))
			->limit(5)->get();
	}

	public function getCountCoursesAttribute()
	{
		return $this->courses->count();
	}

	public function getCountQuizAttribute()
	{
		return $this->quizzes->count();
	}

	public function getPaginateQuizzesAttribute()
	{
		return $this->quizzes()->paginate(7);
	}

	public function getTeacherNameAttribute()
	{
		return $this->teacher->firstname . ' ' . $this->teacher->lastname;
	}

	public function getSubjectNameAttribute()
	{
		return $this->subject->name;
	}

	public function getMajorNameAttribute()
	{
		return $this->major->name;
	}

	public function getClassNameAttribute()
	{
		return $this->grade . ' ' . $this->major->name . ' ' . $this->subject->name;
	}

	public function getAssignmentTitleAttribute()
	{
		return $this->assignments;
	}
	
	public function getAttachedQuizzesAttribute()
	{
		$ids = [];
		foreach ($this->quizzes as $quiz) {
			$ids[] = $quiz->id;
		}

		return $ids;
	}

	public function getAttachedCoursesAttribute()
	{
		$ids = [];
		foreach ($this->courses as $course) {
			$ids[] = $course->id;
		}

		return $ids;
	}

	public function getAttachedAssignmentsAttribute()
	{
		$ids = [];
		foreach ($this->assignments as $assignment) {
			$ids[] = $assignment->id;
		}

		return $ids;
	}
}