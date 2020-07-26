import React, { Component, Fragment } from "react";
import {
  ContractForm,
  AccountData,
  ContractData,
  ContractParameterizableData,
  ContractAllData
} from "drizzle-react-components-plus";
import logo from "../../logo.png";
import Header from "../header/Header";

import dynamicallyAddContract from "../../util/dynamicallyAddContract";

function Greeting(props) {
  const complexStorage = props.complexStorage;
  if (complexStorage) return <ContractAllData contract="ComplexStorage" />;
  return null;
}

class Home extends Component {
  constructor(props, context) {
    super(props);

    this.drizzle = context.drizzle;
  }

  async componentDidMount() {
    await dynamicallyAddContract(
      require("../../../build/contracts/ComplexStorage.json"),
      this.drizzle,
      this.props.accounts[0]
    );
  }

  render() {
    return (
      <Fragment>
        <Header />
        <main className="container">
          <div className="pure-g">
            {/*<div className="pure-u-1-1 header">*/}
            {/*<img src={logo} alt="drizzle-logo" />*/}
            {/*<h1>Drizzle Examples</h1>*/}
            {/*<p>*/}
            {/*Examples of how to get started with Drizzle in various*/}
            {/*situations.*/}
            {/*</p>*/}

            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}

            {/*<div className="pure-u-1-1">*/}
            {/*<h2>Active Account</h2>*/}
            {/*<AccountData accountIndex="0" units="ether" precision="6" />*/}

            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}

            {/*<div className="pure-u-1-1">*/}
            {/*<h2>SimpleStorage</h2>*/}
            {/*<p>*/}
            {/*This shows a simple ContractData component with no arguments,*/}
            {/*along with a form to set its value.*/}
            {/*</p>*/}
            {/*<div>*/}
            {/*<strong>Stored Value</strong>:{" "}*/}
            {/*<ContractData contract="SimpleStorage" method="storedData" />*/}
            {/*</div>*/}
            {/*<Fragment>*/}
            {/*<ContractForm contract="SimpleStorage" method="set" />*/}
            {/*</Fragment>*/}

            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}

            {/*<div className="pure-u-1-1">*/}
            {/*<h2>SimpleStorage All</h2>*/}
            {/*<p>This shows Contract All Possibilities</p>*/}
            {/*<ContractAllData contract="SimpleStorage" />*/}

            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}

            {/*<div className="pure-u-1-1">*/}
            {/*<h2>TutorialToken</h2>*/}
            {/*<p>*/}
            {/*Here we have a form with custom, friendly labels. Also note the*/}
            {/*token symbol will not display a loading indicator. We've*/}
            {/*suppressed it with the <code>hideIndicator</code> prop because*/}
            {/*we know this variable is constant.*/}
            {/*</p>*/}
            {/*<div>*/}
            {/*<strong>Total Supply</strong>:{" "}*/}
            {/*<ContractData*/}
            {/*contract="TutorialToken"*/}
            {/*method="totalSupply"*/}
            {/*methodArgs={[{ from: this.props.accounts[0] }]}*/}
            {/*/>{" "}*/}
            {/*<ContractData*/}
            {/*contract="TutorialToken"*/}
            {/*method="symbol"*/}
            {/*hideIndicator*/}
            {/*/>*/}
            {/*</div>*/}
            {/*<div>*/}
            {/*<strong>My Balance</strong>:{" "}*/}
            {/*<ContractData*/}
            {/*contract="TutorialToken"*/}
            {/*method="balanceOf"*/}
            {/*methodArgs={[this.props.accounts[0]]}*/}
            {/*/>*/}
            {/*</div>*/}
            {/*<div>*/}
            {/*<strong>Anyone's Balance</strong>:{" "}*/}
            {/*<ContractParameterizableData*/}
            {/*contract="TutorialToken"*/}
            {/*method="balanceOf"*/}
            {/*/>*/}
            {/*</div>*/}
            {/*<h3>Send Tokens</h3>*/}
            {/*<ContractForm*/}
            {/*contract="TutorialToken"*/}
            {/*method="transfer"*/}
            {/*labels={["To Address", "Amount to Send"]}*/}
            {/*/>*/}

            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}

            {/*<div className="pure-u-1-1">*/}
            {/*<h2>TutorialToken All</h2>*/}
            {/*<p>This shows Contract All Possibilities</p>*/}
            {/*<ContractAllData contract="TutorialToken" />*/}

            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}

            {/*<div className="pure-u-1-1">*/}
            {/*<h2>ComplexStorage</h2>*/}
            {/*<p>*/}
            {/*Finally this contract shows data types with additional*/}
            {/*considerations. Note in the code the strings below are converted*/}
            {/*from bytes to UTF-8 strings and the device data struct is*/}
            {/*iterated as a list.*/}
            {/*</p>*/}
            {/*<div>*/}
            {/*<strong>String 1</strong>:{" "}*/}
            {/*<ContractData*/}
            {/*contract="ComplexStorage"*/}
            {/*method="string1"*/}
            {/*toUtf8*/}
            {/*/>*/}
            {/*</div>*/}
            {/*<div>*/}
            {/*<strong>String 2</strong>:{" "}*/}
            {/*<ContractData*/}
            {/*contract="ComplexStorage"*/}
            {/*method="string2"*/}
            {/*toUtf8*/}
            {/*/>*/}
            {/*</div>*/}
            {/*<div>*/}
            {/*<strong>Single Device Data</strong>:{" "}*/}
            {/*<ContractData contract="ComplexStorage" method="singleDD" />*/}
            {/*<br />*/}
            {/*<br />*/}
            {/*</div>*/}
            {/*</div>*/}

            <div className="pure-u-1-1">
              <h2>ComplexStorage All</h2>
              <p>This shows Contract All Possibilities</p>
              <Greeting
                complexStorage={this.drizzle.contracts.ComplexStorage}
              />
              <br />
              <br />
            </div>
          </div>
        </main>
      </Fragment>
    );
  }
}

export default Home;
