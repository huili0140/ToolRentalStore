# Tool Rental Store

## 1 Project Overview

A tool rental store has decided to try out a new online tool rental service for its customers. My job is to develop the information management system that supports the online inventory, reservation services, and mainteinance services. 

### 1.1 Tool

**Tool Type:** The store has four types of tools available for rental: Hand Tools, Garden Tools, Ladders, and Power Tools. Hand tools include items such as wrenches, sockets, screwdrivers, hammers, etc. Garden tools include digging tools, pruning tools, trimmers, rakes, wheelbarrows, and striking tools. Ladders include straight and step. Power Tools include drills, saws, sanders, mixers,
etc.

**Power Type:** Tools are also divided into 4 separate sub-types based on power source: 110-240 Volt A/C electric (corded), 7.2-80.0 Volt D/C battery powered (cordless), gas-powered, and manual (no motor). Garden Tools may run on any power-source: manual, gas, electric, or cordless. All Ladders, all Hand Tools are considered manualpowered.

**Accessories:** Tool accessories are unique to power tools and must be listed separately (e.g. drill bits, hose, gas tank, hard case, safety wear, etc). Each tool may have more than one accessory. All accessories must be paired at the time of rental and/or sale with their applicable power tool.

### 1.2 Customers

**Register and Login:** A Customer is any user interested in renting a tool. A Customer need to register into the system first by providing contact information and optional credit card information on the Registration form. Then the customer can login by entering the username and password and selecting the “Customer” radio button on the Login form.  

**View Profile:** When a rental Customer selects the “View Profile” task from the main menu, the View Profile page is loaded into the browser. The profile lists all of the known information about the user including profile information and rental history. The rental history lists the summaries for all reservations made by the user, ordered from most recent to oldest, and includes the names of Clerk who handled the each part of the reservation (pick-up/drop-off).

**Check Tool Availability:** Customers are able to check the inventory of the store available over a specific time period. Customers have the option to customize a search for a given tool by using any combination of start/end dates, tool category, power-source/sub-types, and/or keyword search. After pressing the search button, the rental Customer is presented with the inventory available during their specified time frame and search criteria, displaying unique tool number, a short-description, deposit price, and rental price.

**Make Reservation:** A Customer is allowed to rent no more than 10 tools per reservation. Once the 11th tool is requested, an error message is displayed prompting the user to reduce the number of tools in the current reservation to 10. Customers are free to add/remove tools as needed to fulfill their reservation request. When the “Calculate Total” button is pressed, a summary of the reservation is displayed before being entered into the system. The total rental price and the total deposit price, which will be refunded upon returning the tools, is displayed for all tools. When the “Submit” button is pressed, a final reservation screen pops up if the reservation is successful, displaying the unique confirmation number in addition to the reservation summary with totals.

### 1.3 Clerk

**Login:** A Clerk on duty represents the employee responsible for handling the tool inventory. The profile information of a Clerk is entered into the system by the System Administrator. A Clerk login to the system by entering the username and password and selecting the "Clerk" radio button on the Login form. 

**Pick-Up Reservation:** 

**Drop-Off Reservation:** 

**Add Tool:** 

**Generate Report:**

## 2 Database Design

### 2.1 Enhanced Entity-Relationship Diagram
![EER Diagram](Diagrams/EER.pdf)

### 2.2 EER to Relation Mapping
![EER To REL Diagram](Diagrams/EER2REL.pdf)



