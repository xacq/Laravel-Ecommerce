<div class="form-group">
 <label for="parent_id">Selecionar el Nivel de Categoría</label>
  <select name="parent_id" id="parent_id" class="form-control" style="color: #495057;">
    <option value="0" @if(isset($category['parent_id']) && $category['parent_id']==0) selected="" @endif>Categoría Principal</option>
    @if(!empty($getCategories))  
        @foreach($getCategories as $parentcategory)
            <option value="{{ $parentcategory['id'] }}" @if(isset($category['parent_id']) && $category['parent_id']==$parentcategory['id']) selected="" @endif>{{ $parentcategory['categoria_nombre'] }}</option>
        @if(!empty($parentcategory['subcategories']))  
        @foreach($parentcategory['subcategories'] as $subcategory)
            <option value="{{ $subcategory['id'] }}" @if(isset($subcategory['parent_id']) && $subcategory['parent_id']==$subcategory['id'] ) selected="" @endif>&nbsp;&raquo;&nbsp;{{ $subcategory['categoria_nombre'] }}</option>
        @endforeach
        @endif  
        @endforeach 
    @endif
  </select>
</div> 
