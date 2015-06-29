<label for="RegionSelect">Region/State</label>
<select class="form-control" name="state_a2" id="state_a2" >
    <option value=""> - Select Region/State - </option>    
    @foreach($states as $value)
        <option value="{{ $value->a2 }}">{{ $value->name }}</option>
    @endforeach
</select>