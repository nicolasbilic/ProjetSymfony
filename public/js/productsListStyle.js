//Get parent container
export default function productsListStyle() {
  const categoriesContainer = document.querySelector(
    "#allProducts .categoriesContainer"
  );
  //if parentConntainer exist
  if (categoriesContainer) {
    //Get first element from the container
    const firstChild = categoriesContainer.firstElementChild;
    const secondChild = categoriesContainer.children[1];
    const lastChild = categoriesContainer.lastElementChild;
    const penultimateChild = lastChild.previousElementSibling;
    const lastChildContainer = document.createElement("div");
    const childrenCount = categoriesContainer.children.length;
    //Get the distance between the border container and firstChild
    let leftOffsetFirstChild = firstChild.offsetLeft;
    let leftOffsetSecondChild = secondChild.offsetLeft;
    let rightOffsetFirstChild = firstChild.offsetLeft + firstChild.offsetWidth;
    let distanceBetweenElements = leftOffsetSecondChild - rightOffsetFirstChild;
    let elementWidth = firstChild.offsetWidth;

    lastChildContainer.style.width = "100%";
    lastChildContainer.style.display = "flex";
    lastChildContainer.style.paddingLeft =
      leftOffsetFirstChild.toString() - 20 + "px";
    if (childrenCount % 3 === 1) {
      lastChild.style.marginLeft = 0;
      lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
      lastChild.style.width = elementWidth.toString() + "px";
      categoriesContainer.appendChild(lastChildContainer);
      lastChildContainer.appendChild(lastChild);
      const handleResize = () => {
        leftOffsetFirstChild = firstChild.offsetLeft;
        leftOffsetSecondChild = secondChild.offsetLeft;
        rightOffsetFirstChild = firstChild.offsetLeft + firstChild.offsetWidth;
        distanceBetweenElements = leftOffsetSecondChild - rightOffsetFirstChild;
        elementWidth = firstChild.offsetWidth;
        lastChildContainer.style.paddingLeft =
          leftOffsetFirstChild.toString() - 20 + "px";
        lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
        lastChild.style.width = elementWidth.toString() + "px";
      };
      window.addEventListener("resize", handleResize);
    } else if (childrenCount % 3 === 2) {
      lastChild.style.marginLeft = 0;
      penultimateChild.style.marginLeft = 0;
      lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
      lastChild.style.width = elementWidth.toString() + "px";
      penultimateChild.style.width = elementWidth.toString() + "px";
      categoriesContainer.appendChild(lastChildContainer);
      lastChildContainer.appendChild(lastChild);
      lastChildContainer.appendChild(penultimateChild);
      const handleResize = () => {
        leftOffsetFirstChild = firstChild.offsetLeft;
        leftOffsetSecondChild = secondChild.offsetLeft;
        rightOffsetFirstChild = firstChild.offsetLeft + firstChild.offsetWidth;
        distanceBetweenElements = leftOffsetSecondChild - rightOffsetFirstChild;
        elementWidth = firstChild.offsetWidth;
        lastChildContainer.style.paddingLeft =
          leftOffsetFirstChild.toString() - 20 + "px";
        lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
        lastChild.style.width = elementWidth.toString() + "px";
        penultimateChild.style.width = elementWidth.toString() + "px";
      };
      window.addEventListener("resize", handleResize);
    }
  }
}

productsListStyle();
