<select name="departments[]" id="departments" multiple="true" class="form-control">
    @foreach($departments as $department)
        <option value="{{ $department->id }}" {{ in_array($department->id, old('departments', [])) || (isset($object) && $object->departments->contains($department)) ? 'selected' : '' }}>{{ $department->name }}</option>
    @endforeach
</select>