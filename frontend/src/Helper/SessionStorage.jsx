export const setMessages = (messages) => {
    sessionStorage.setItem("messages", JSON.stringify(messages));
};

export const getMessages = () => {
    const messages = sessionStorage.getItem("messages");
    const retMessages = messages ? JSON.parse(messages) : [];
    return retMessages;
};

export const clearMessages = () => {
    sessionStorage.removeItem("messages");
};

export const clearMessagesForComponent = (component) => {
    let messages = getMessages();
    messages = messages.filter(msg => msg.component !== component);
    setMessages(messages);
};

export const addMessage = (type, component, componentFunction, message) => {
    let messages = getMessages();

    const index = messages.findIndex(msg => 
        msg.type === type && 
        msg.component === component && 
        msg.componentFunction === componentFunction
    );

    if (index !== -1) {
        messages[index].message = message;
    } else {
        messages.push({ type, component, componentFunction, message });
    }

    setMessages(messages);
};

export const setComponentForDelayedClear = (componentName) => {
    console.log("SessionStorage - set delayed component: ", componentName);
    sessionStorage.setItem("componentdelayed", componentName);
};

export const getComponentForDelayedClear = () => {
    console.log("SessionStorage - get delayed component: ", sessionStorage.getItem("componentdelayed"));
    return sessionStorage.getItem("componentdelayed");
};

export const clearComponentForDelayedClear = () => {
    console.log("SessionStorage - clear delayed component: ", sessionStorage.getItem("componentdelayed"));
    sessionStorage.removeItem("componentdelayed");
};

