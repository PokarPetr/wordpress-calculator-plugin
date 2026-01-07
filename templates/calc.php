<div class="calculator-block">
  <form class="calc-form">
    <input type="number" name="num1" step="any" placeholder="Input a number" required>
    <input type="number" name="num2" step="any" placeholder="Input a number" required>
    <div class="calc-action">
      <select name="operation">
        <option value="add">+</option>
        <option value="subtract">-</option>
        <option value="multiply">*</option>
        <option value="divide">/</option>
        <option value="power">¬</option>
    </select>
    <button type="submit">Calculate</button>
    </div>
  </form>
  <div class="calc-result" style="display:none;"></div>
  <div class="calc-action">
    <button class="calc-use-result" style="display:none;">Use result</button>
    <button class="calc-reset" style="display:none;">Reset</button>
  </div>
</div>