//Get the parent container for the products list
export default function productsListStyle() {
  const categoriesContainer = document.querySelector(
    "#allProducts .categoriesContainer"
  );

  //Check if the parent container exists
  if (categoriesContainer) {
    //Get references to the first, second, last, and penultimate child elements
    const firstChild = categoriesContainer.firstElementChild;
    const secondChild = categoriesContainer.children[1];
    const lastChild = categoriesContainer.lastElementChild;
    const penultimateChild = lastChild.previousElementSibling;

    //Create a new container for the last child element
    const lastChildContainer = document.createElement("div");

    //Get the total number of children in the container
    const childrenCount = categoriesContainer.children.length;

    //Get the initial offset values and distances between elements
    let leftOffsetFirstChild = firstChild.offsetLeft;
    let leftOffsetSecondChild = secondChild.offsetLeft;
    let rightOffsetFirstChild = firstChild.offsetLeft + firstChild.offsetWidth;
    let distanceBetweenElements = leftOffsetSecondChild - rightOffsetFirstChild;
    let elementWidth = firstChild.offsetWidth;

    //Set styles for the new container
    lastChildContainer.style.width = "100%";
    lastChildContainer.style.display = "flex";
    lastChildContainer.style.paddingLeft =
      leftOffsetFirstChild.toString() - 20 + "px";

    //Handle based on the number of children
    if (childrenCount % 3 === 1) {
      //Adjust styles for the last child if there is one extra element
      lastChild.style.marginLeft = 0;
      lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
      lastChild.style.width = elementWidth.toString() + "px";

      // Append the new container and move the last child into it
      categoriesContainer.appendChild(lastChildContainer);
      lastChildContainer.appendChild(lastChild);

      //Add a resize event listener to handle responsive adjustments
      const handleResize = () => {
        //Update offset and distance values on resize
        leftOffsetFirstChild = firstChild.offsetLeft;
        leftOffsetSecondChild = secondChild.offsetLeft;
        rightOffsetFirstChild = firstChild.offsetLeft + firstChild.offsetWidth;
        distanceBetweenElements = leftOffsetSecondChild - rightOffsetFirstChild;
        elementWidth = firstChild.offsetWidth;

        //Adjust styles based on the updated values
        lastChildContainer.style.paddingLeft =
          leftOffsetFirstChild.toString() - 20 + "px";
        lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
        lastChild.style.width = elementWidth.toString() + "px";
      };

      //Attach the resize event listener
      window.addEventListener("resize", handleResize);
    } else if (childrenCount % 3 === 2) {
      //Adjust styles for the last and penultimate child if there are two extra elements
      lastChild.style.marginLeft = 0;
      penultimateChild.style.marginLeft = 0;
      lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
      lastChild.style.width = elementWidth.toString() + "px";
      penultimateChild.style.width = elementWidth.toString() + "px";

      //Append the new container and move the last and penultimate children into it
      categoriesContainer.appendChild(lastChildContainer);
      lastChildContainer.appendChild(lastChild);
      lastChildContainer.appendChild(penultimateChild);

      //Add a resize event listener to handle responsive adjustments
      const handleResize = () => {
        //Update offset and distance values on resize
        leftOffsetFirstChild = firstChild.offsetLeft;
        leftOffsetSecondChild = secondChild.offsetLeft;
        rightOffsetFirstChild = firstChild.offsetLeft + firstChild.offsetWidth;
        distanceBetweenElements = leftOffsetSecondChild - rightOffsetFirstChild;
        elementWidth = firstChild.offsetWidth;

        //Adjust styles based on the updated values
        lastChildContainer.style.paddingLeft =
          leftOffsetFirstChild.toString() - 20 + "px";
        lastChild.style.marginRight = distanceBetweenElements.toString() + "px";
        lastChild.style.width = elementWidth.toString() + "px";
        penultimateChild.style.width = elementWidth.toString() + "px";
      };

      //Attach the resize event listener
      window.addEventListener("resize", handleResize);
    }
  }
}

//Call the function to apply the styling logic
productsListStyle();
