<style>
span
{
  margin: 7px 0;
  display: block;
  width: 100%;
  float: left;
}
input[type="checkbox"]
{
  opacity: 0;
}
input[type="checkbox"] + label
{
  cursor: pointer;
  padding: 4px 10px;
  background: #999999;
  border: 1px solid #999999;
  color: white;
  border-radius: 3px;
  text-shadow: 1px 1px 0 rgba(0,0,0,0);
}
input[type="checkbox"]:checked + label
{
  background: #3333ff;
  border: 1px solid #3333ff;
  text-shadow: 1px 1px 0 rgba(0,0,0,0.4);
  color: white;
}
</style>