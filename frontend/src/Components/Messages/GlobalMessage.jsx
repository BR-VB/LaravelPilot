import { clearComponentForDelayedClear, getComponentForDelayedClear, getMessages, clearMessagesForComponent } from "@/Helper/SessionStorage";

const GlobalMessage = () => {
    const componentName = "GlobalMessage";

    const messages = getMessages();
    const componentToClear = getComponentForDelayedClear();

    console.log("GlobalMessage - ComponentToClear: ", componentToClear);

    if (componentToClear) {
        console.log("GlobalMessage - ComponentToClear is set: ", componentToClear);
        clearComponentForDelayedClear();
        clearMessagesForComponent(componentToClear);
    }

    const getMessageClasses = (messageType) => {
        console.log(componentName + " - getMessageClasses");
        switch (messageType) {
            case 'success':
                return 'bg-green-50 text-green-800';
            case 'warning':
                return 'bg-yellow-50 text-yellow-800';
            case 'error':
                return 'bg-red-50 text-red-800';
            default:
                return '';
        }
    };

    if (messages.length === 0) {
        console.log(componentName + " - no messages found");
        return null; 
    } else {
        console.log(componentName + " - messages found");
    }

    return (
        <div className="mt-2 p-2 border rounded-lg shadow-md bg-white">
            <ul>
                {messages.map((msg, index) => (
                <li key={index} className={`px-10 py-2 rounded-md ${getMessageClasses(msg.type)}`}>
                    <span className="text-sm italic opacity-80">[{msg.component}, {msg.componentFunction}]</span> - <strong>{msg.type.toUpperCase()}</strong> : {msg.message}
                </li>
                ))}
            </ul>
        </div>
    );
};

export default GlobalMessage;
